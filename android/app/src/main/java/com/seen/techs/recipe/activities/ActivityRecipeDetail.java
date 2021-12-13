package com.seen.techs.recipe.activities;

import static com.seen.techs.recipe.config.AppConfig.RTL_MODE;
import static com.seen.techs.recipe.utils.Constant.BANNER_RECIPE_DETAIL;
import static com.seen.techs.recipe.utils.Constant.INTERSTITIAL_ON_RECIPES_LIST;
import static com.seen.techs.recipe.utils.Constant.NATIVE_AD_RECIPES_DETAIL;

import android.content.Intent;
import android.content.res.Resources;
import android.graphics.Color;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.TextView;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;
import androidx.recyclerview.widget.RecyclerView;
import androidx.recyclerview.widget.StaggeredGridLayoutManager;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;
import androidx.viewpager.widget.ViewPager;

import com.seen.techs.recipe.BuildConfig;
import com.seen.techs.recipe.R;
import com.seen.techs.recipe.adapters.AdapterImage;
import com.seen.techs.recipe.adapters.AdapterSuggested;
import com.seen.techs.recipe.callbacks.CallbackRecipeDetail;
import com.seen.techs.recipe.config.AppConfig;
import com.seen.techs.recipe.databases.prefs.AdsPref;
import com.seen.techs.recipe.databases.prefs.SharedPref;
import com.seen.techs.recipe.databases.sqlite.DbHandler;
import com.seen.techs.recipe.models.Images;
import com.seen.techs.recipe.models.Recipe;
import com.seen.techs.recipe.rests.RestAdapter;
import com.seen.techs.recipe.utils.AdsManager;
import com.seen.techs.recipe.utils.AppBarLayoutBehavior;
import com.seen.techs.recipe.utils.Constant;
import com.seen.techs.recipe.utils.Tools;
import com.facebook.shimmer.ShimmerFrameLayout;
import com.google.android.material.appbar.AppBarLayout;
import com.google.android.material.snackbar.Snackbar;
import com.google.android.material.tabs.TabLayout;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ActivityRecipeDetail extends AppCompatActivity {

    private Call<CallbackRecipeDetail> callbackCall = null;
    private LinearLayout lyt_main_content;
    private Recipe post;
    TextView txt_recipe_title, txt_category, txt_recipe_time, txt_total_views;
    LinearLayout lyt_view;
    ImageView thumbnail_video;
    private WebView recipe_description;
    DbHandler databaseHandler;
    CoordinatorLayout parent_view;
    private ShimmerFrameLayout lyt_shimmer;
    RelativeLayout lyt_suggested;
    private SwipeRefreshLayout swipe_refresh;
    SharedPref sharedPref;
    ImageButton image_favorite, btn_share;
    ViewPager viewPager;
    AdsPref adsPref;
    AdsManager adsManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Tools.getTheme(this);
        setContentView(R.layout.activity_recipe_detail);
        Tools.getLayoutDirections(this, RTL_MODE);

        sharedPref = new SharedPref(this);
        adsPref = new AdsPref(this);
        databaseHandler = new DbHandler(this);

        AppBarLayout appBarLayout = findViewById(R.id.appbar);
        ((CoordinatorLayout.LayoutParams) appBarLayout.getLayoutParams()).setBehavior(new AppBarLayoutBehavior());

        adsManager = new AdsManager(this);
        adsManager.loadBannerAd(BANNER_RECIPE_DETAIL);
        adsManager.loadInterstitialAd(INTERSTITIAL_ON_RECIPES_LIST, adsPref.getInterstitialAdInterval());
        adsManager.loadNativeAd(NATIVE_AD_RECIPES_DETAIL);

        swipe_refresh = findViewById(R.id.swipe_refresh_layout);
        swipe_refresh.setColorSchemeResources(R.color.colorPrimary);
        swipe_refresh.setRefreshing(false);

        lyt_main_content = findViewById(R.id.lyt_main_content);
        lyt_shimmer = findViewById(R.id.shimmer_view_container);
        parent_view = findViewById(R.id.lyt_content);

        thumbnail_video = findViewById(R.id.thumbnail_video);
        txt_recipe_title = findViewById(R.id.recipe_title);
        txt_category = findViewById(R.id.category_name);
        txt_recipe_time = findViewById(R.id.recipe_time);
        recipe_description = findViewById(R.id.recipe_description);
        txt_total_views = findViewById(R.id.total_views);
        lyt_view = findViewById(R.id.lyt_view_count);

        image_favorite = findViewById(R.id.img_favorite);
        btn_share = findViewById(R.id.btn_share);

        lyt_suggested = findViewById(R.id.lyt_suggested);

        post = (Recipe) getIntent().getSerializableExtra(Constant.EXTRA_OBJC);

        requestAction();

        swipe_refresh.setOnRefreshListener(() -> {
            lyt_shimmer.setVisibility(View.VISIBLE);
            lyt_shimmer.startShimmer();
            lyt_main_content.setVisibility(View.GONE);
            requestAction();
        });

        initToolbar();
        initFavorite();
        loadViewed();

    }

    private void requestAction() {
        showFailedView(false, "");
        swipeProgress(true);
        new Handler().postDelayed(this::requestPostData, 200);
    }

    private void requestPostData() {
        this.callbackCall = RestAdapter.createAPI(sharedPref.getApiUrl()).getRecipeDetail(post.recipe_id);
        this.callbackCall.enqueue(new Callback<CallbackRecipeDetail>() {
            public void onResponse(Call<CallbackRecipeDetail> call, Response<CallbackRecipeDetail> response) {
                CallbackRecipeDetail responseHome = response.body();
                if (responseHome == null || !responseHome.status.equals("ok")) {
                    onFailRequest();
                    return;
                }
                displayAllData(responseHome);
                swipeProgress(false);
                lyt_main_content.setVisibility(View.VISIBLE);
            }

            public void onFailure(Call<CallbackRecipeDetail> call, Throwable th) {
                Log.e("onFailure", th.getMessage());
                if (!call.isCanceled()) {
                    onFailRequest();
                }
            }
        });
    }

    private void onFailRequest() {
        swipeProgress(false);
        lyt_main_content.setVisibility(View.GONE);
        if (Tools.isConnect(ActivityRecipeDetail.this)) {
            showFailedView(true, getString(R.string.failed_text));
        } else {
            showFailedView(true, getString(R.string.failed_text));
        }
    }

    private void showFailedView(boolean show, String message) {
        View lyt_failed = findViewById(R.id.lyt_failed_home);
        ((TextView) findViewById(R.id.failed_message)).setText(message);
        if (show) {
            lyt_failed.setVisibility(View.VISIBLE);
        } else {
            lyt_failed.setVisibility(View.GONE);
        }
        findViewById(R.id.failed_retry).setOnClickListener(view -> requestAction());
    }

    private void swipeProgress(final boolean show) {
        if (!show) {
            swipe_refresh.setRefreshing(show);
            lyt_shimmer.setVisibility(View.GONE);
            lyt_shimmer.stopShimmer();
            lyt_main_content.setVisibility(View.VISIBLE);
            return;
        }
        lyt_main_content.setVisibility(View.GONE);
    }

    private void displayAllData(CallbackRecipeDetail responseHome) {
        displayImages(responseHome.images);
        displayData(responseHome.post);
        displaySuggested(responseHome.related);
    }

    private void displayImages(final List<Images> list) {

        viewPager = findViewById(R.id.view_pager_image);
        final AdapterImage adapter = new AdapterImage(this, list);
        viewPager.setAdapter(adapter);
        viewPager.setOffscreenPageLimit(4);

        viewPager.addOnPageChangeListener(new ViewPager.SimpleOnPageChangeListener() {

            public void onPageSelected(int position) {
                super.onPageSelected(position);
                if (position < list.size()) {

                }
            }
        });

        TabLayout tabLayout = findViewById(R.id.tabDots);
        tabLayout.setupWithViewPager(viewPager, true);

        if (list.size() > 1) {
            tabLayout.setVisibility(View.VISIBLE);
        } else {
            tabLayout.setVisibility(View.GONE);
        }

        if (RTL_MODE) {
            viewPager.setRotationY(180);
        }

        adapter.setOnItemClickListener((view, p, position) -> {
            switch (p.content_type) {
                case "youtube": {
                    Intent intent = new Intent(getApplicationContext(), ActivityYoutubePlayer.class);
                    intent.putExtra("video_id", post.video_id);
                    startActivity(intent);
                    break;
                }
                case "Url": {
                    Intent intent = new Intent(getApplicationContext(), ActivityVideoPlayer.class);
                    intent.putExtra("video_url", post.video_url);
                    startActivity(intent);
                    break;
                }
                case "Upload": {
                    Intent intent = new Intent(getApplicationContext(), ActivityVideoPlayer.class);
                    intent.putExtra("video_url", sharedPref.getApiUrl() + "/upload/video/" + post.video_url);
                    startActivity(intent);
                    break;
                }
                default: {
                    Intent intent = new Intent(getApplicationContext(), ActivityImageSlider.class);
                    intent.putExtra("position", position);
                    intent.putExtra("recipe_id", post.recipe_id);
                    startActivity(intent);
                    break;
                }
            }
        });

    }

    public void displayData(final Recipe post) {

        txt_recipe_title.setText(post.recipe_title);
        txt_recipe_time.setText(post.recipe_time);

        if (AppConfig.ENABLE_RECIPES_VIEW_COUNT) {
            txt_total_views.setText(Tools.withSuffix(post.total_views) + " " + getResources().getString(R.string.views_count));
        } else {
            lyt_view.setVisibility(View.GONE);
        }

        if (post.content_type != null && post.content_type.equals("Post")) {
            thumbnail_video.setVisibility(View.GONE);
        } else {
            thumbnail_video.setVisibility(View.VISIBLE);
        }

        recipe_description.setBackgroundColor(Color.TRANSPARENT);
        recipe_description.setFocusableInTouchMode(false);
        recipe_description.setFocusable(false);
        recipe_description.getSettings().setDefaultTextEncodingName("UTF-8");

        WebSettings webSettings = recipe_description.getSettings();
        Resources res = getResources();
        int fontSize = res.getInteger(R.integer.font_size);
        webSettings.setDefaultFontSize(fontSize);

        String mimeType = "text/html; charset=UTF-8";
        String encoding = "utf-8";
        String htmlText = post.recipe_description;

        String bg_paragraph;
        if (sharedPref.getIsDarkTheme()) {
            bg_paragraph = "<style type=\"text/css\">body{color: #eeeeee;}";
        } else {
            bg_paragraph = "<style type=\"text/css\">body{color: #000000;}";
        }

        String font_style_default = "<style type=\"text/css\">@font-face {font-family: MyFont;src: url(\"file:///android_asset/font/custom_font.ttf\")}body {font-family: MyFont; font-size: medium; text-align: left;}</style>";

        String text = "<html><head>"
                + font_style_default
                + "<style>img{max-width:100%;height:auto;} figure{max-width:100%;height:auto;} iframe{width:100%;}</style> "
                + bg_paragraph
                + "</style></head>"
                + "<body>"
                + htmlText
                + "</body></html>";

        String text_rtl = "<html dir='rtl'><head>"
                + font_style_default
                + "<style>img{max-width:100%;height:auto;} figure{max-width:100%;height:auto;} iframe{width:100%;}</style> "
                + bg_paragraph
                + "</style></head>"
                + "<body>"
                + htmlText
                + "</body></html>";

        if (RTL_MODE) {
            recipe_description.loadDataWithBaseURL(null, text_rtl, mimeType, encoding, null);
        } else {
            recipe_description.loadDataWithBaseURL(null, text, mimeType, encoding, null);
        }

        btn_share.setOnClickListener(view -> {
            String share_title = android.text.Html.fromHtml(post.recipe_title).toString();
            String share_content = android.text.Html.fromHtml(getResources().getString(R.string.share_text)).toString();
            Intent sendIntent = new Intent();
            sendIntent.setAction(Intent.ACTION_SEND);
            sendIntent.putExtra(Intent.EXTRA_TEXT, share_title + "\n\n" + share_content + "\n\n" + "https://play.google.com/store/apps/details?id=" + BuildConfig.APPLICATION_ID);
            sendIntent.setType("text/plain");
            startActivity(sendIntent);
        });

        addToFavorite();
        new Handler().postDelayed(() -> lyt_suggested.setVisibility(View.VISIBLE), 1000);

    }

    private void displaySuggested(List<Recipe> list) {

        RecyclerView recyclerView = findViewById(R.id.recycler_view_suggested);

        recyclerView.setLayoutManager(new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.VERTICAL));

        AdapterSuggested adapterSuggested = new AdapterSuggested(ActivityRecipeDetail.this, recyclerView, list);
        recyclerView.setAdapter(adapterSuggested);
        recyclerView.setNestedScrollingEnabled(false);
        adapterSuggested.setOnItemClickListener((view, obj, position) -> {
            Intent intent = new Intent(getApplicationContext(), ActivityRecipeDetail.class);
            intent.putExtra(Constant.EXTRA_OBJC, obj);
            startActivity(intent);
            adsManager.showInterstitialAd();
        });

        TextView txt_suggested = findViewById(R.id.txt_suggested);
        if (list.size() > 0) {
            txt_suggested.setText(getResources().getString(R.string.txt_suggested));
        } else {
            txt_suggested.setText("");
        }

    }

    private void initToolbar() {
        final Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        if (sharedPref.getIsDarkTheme()) {
            toolbar.setBackgroundColor(getResources().getColor(R.color.colorToolbarDark));
        } else {
            toolbar.setBackgroundColor(getResources().getColor(R.color.colorPrimary));
        }

        final ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setHomeButtonEnabled(true);
            getSupportActionBar().setTitle("");
        }

        txt_category.setText(post.category_name);

    }

    @Override
    public boolean onCreateOptionsMenu(final Menu menu) {
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    public void initFavorite() {
        List<Recipe> data = databaseHandler.getFavRow(post.recipe_id);
        if (data.size() == 0) {
            image_favorite.setImageResource(R.drawable.ic_fav_outline);
        } else {
            if (data.get(0).getRecipe_id().equals(post.recipe_id)) {
                image_favorite.setImageResource(R.drawable.ic_fav);
            }
        }
    }

    public void addToFavorite() {

        image_favorite.setOnClickListener(view -> {
            List<Recipe> data1 = databaseHandler.getFavRow(post.recipe_id);
            if (data1.size() == 0) {
                databaseHandler.AddtoFavorite(new Recipe(
                        post.category_name,
                        post.recipe_id,
                        post.recipe_title,
                        post.recipe_time,
                        post.recipe_image,
                        post.recipe_description,
                        post.video_url,
                        post.video_id,
                        post.content_type,
                        post.featured,
                        post.tags,
                        post.total_views
                ));
                Snackbar.make(parent_view, R.string.favorite_added, Snackbar.LENGTH_SHORT).show();
                image_favorite.setImageResource(R.drawable.ic_fav);
            } else {
                if (data1.get(0).getRecipe_id().equals(post.recipe_id)) {
                    databaseHandler.RemoveFav(new Recipe(post.recipe_id));
                    Snackbar.make(parent_view, R.string.favorite_removed, Snackbar.LENGTH_SHORT).show();
                    image_favorite.setImageResource(R.drawable.ic_fav_outline);
                }
            }
        });

    }

    @Override
    public boolean onOptionsItemSelected(MenuItem menuItem) {
        switch (menuItem.getItemId()) {
            case android.R.id.home:
                onBackPressed();
                break;

            default:
                return super.onOptionsItemSelected(menuItem);
        }
        return true;
    }

    private void loadViewed() {
        if (Tools.isConnect(this)) {
            new MyTask().execute(sharedPref.getApiUrl() + "/api/api.php?get_total_views&id=" + post.recipe_id);
        }
    }

    @SuppressWarnings("deprecation")
    private static class MyTask extends AsyncTask<String, Void, String> {

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
        }

        @Override
        protected String doInBackground(String... params) {
            return Tools.getJSONString(params[0]);
        }

        @Override
        protected void onPostExecute(String result) {
            super.onPostExecute(result);

            if (null == result || result.length() == 0) {
                Log.d("TAG", "no data found!");
            } else {

                try {

                    JSONObject mainJson = new JSONObject(result);
                    JSONArray jsonArray = mainJson.getJSONArray("result");
                    JSONObject objJson = null;
                    for (int i = 0; i < jsonArray.length(); i++) {
                        objJson = jsonArray.getJSONObject(i);
                    }

                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }

        }
    }

    public void onDestroy() {
        if (!(callbackCall == null || callbackCall.isCanceled())) {
            this.callbackCall.cancel();
        }
        lyt_shimmer.stopShimmer();
        super.onDestroy();
    }

    @Override
    protected void onResume() {
        super.onResume();
    }

    @Override
    protected void onPause() {
        super.onPause();
    }

}
