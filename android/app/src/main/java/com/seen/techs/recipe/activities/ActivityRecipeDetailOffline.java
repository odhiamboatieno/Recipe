package com.seen.techs.recipe.activities;

import static com.seen.techs.recipe.config.AppConfig.RTL_MODE;

import android.content.Intent;
import android.content.res.Resources;
import android.graphics.Color;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.widget.ImageButton;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.coordinatorlayout.widget.CoordinatorLayout;

import com.seen.techs.recipe.BuildConfig;
import com.seen.techs.recipe.R;
import com.seen.techs.recipe.config.AppConfig;
import com.seen.techs.recipe.databases.prefs.SharedPref;
import com.seen.techs.recipe.databases.sqlite.DbHandler;
import com.seen.techs.recipe.models.Recipe;
import com.seen.techs.recipe.utils.AppBarLayoutBehavior;
import com.seen.techs.recipe.utils.Constant;
import com.seen.techs.recipe.utils.Tools;
import com.google.android.material.appbar.AppBarLayout;
import com.google.android.material.snackbar.Snackbar;
import com.squareup.picasso.Picasso;

import java.util.List;

public class ActivityRecipeDetailOffline extends AppCompatActivity {

    private Recipe post;
    TextView txt_recipe_title, txt_category, txt_recipe_time, txt_total_views;
    LinearLayout lyt_view;
    ImageView thumbnail_video;
    ImageView recipe_image;
    private WebView recipe_description;
    DbHandler databaseHandler;
    CoordinatorLayout parent_view;
    SharedPref sharedPref;
    ImageButton image_favorite, btn_share;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Tools.getTheme(this);
        setContentView(R.layout.activity_recipe_detail_offline);

        sharedPref = new SharedPref(this);
        databaseHandler = new DbHandler(this);
        Tools.getLayoutDirections(this, RTL_MODE);

        AppBarLayout appBarLayout = findViewById(R.id.appbar);
        ((CoordinatorLayout.LayoutParams) appBarLayout.getLayoutParams()).setBehavior(new AppBarLayoutBehavior());

        parent_view = findViewById(R.id.lyt_content);

        thumbnail_video = findViewById(R.id.thumbnail_video);
        recipe_image = findViewById(R.id.recipe_image);
        txt_recipe_title = findViewById(R.id.recipe_title);
        txt_category = findViewById(R.id.category_name);
        txt_recipe_time = findViewById(R.id.recipe_time);
        recipe_description = findViewById(R.id.recipe_description);
        txt_total_views = findViewById(R.id.total_views);
        lyt_view = findViewById(R.id.lyt_view_count);

        image_favorite = findViewById(R.id.img_favorite);
        btn_share = findViewById(R.id.btn_share);

        post = (Recipe) getIntent().getSerializableExtra(Constant.EXTRA_OBJC);

        initToolbar();
        initFavorite();
        displayData();


    }

    public void displayData() {

        txt_recipe_title.setText(post.recipe_title);
        txt_category.setText(post.category_name);
        txt_recipe_time.setText(post.recipe_time);

        if (AppConfig.ENABLE_RECIPES_VIEW_COUNT) {
            txt_total_views.setText(Tools.withSuffix(post.total_views) + " " + getResources().getString(R.string.views_count));
        } else {
            lyt_view.setVisibility(View.GONE);
        }

        if (post.content_type != null && post.content_type.equals("youtube")) {
            Picasso.get()
                    .load(Constant.YOUTUBE_IMAGE_FRONT + post.video_id + Constant.YOUTUBE_IMAGE_BACK_MQ)
                    .placeholder(R.drawable.ic_thumbnail)
                    .into(recipe_image);
        } else {
            Picasso.get()
                    .load(sharedPref.getApiUrl() + "/upload/" + post.recipe_image)
                    .placeholder(R.drawable.ic_thumbnail)
                    .into(recipe_image);
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

}
