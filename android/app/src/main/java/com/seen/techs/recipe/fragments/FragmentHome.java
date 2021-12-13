package com.seen.techs.recipe.fragments;

import static com.seen.techs.recipe.utils.Constant.NATIVE_AD_HOME;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.recyclerview.widget.StaggeredGridLayoutManager;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;
import androidx.viewpager.widget.ViewPager;

import com.seen.techs.recipe.R;
import com.seen.techs.recipe.activities.ActivityCategoryDetail;
import com.seen.techs.recipe.activities.ActivityRecipeDetail;
import com.seen.techs.recipe.activities.ActivityRecipeList;
import com.seen.techs.recipe.activities.MainActivity;
import com.seen.techs.recipe.adapters.AdapterFeatured;
import com.seen.techs.recipe.adapters.AdapterHomeCategory;
import com.seen.techs.recipe.adapters.AdapterHomeRecipes;
import com.seen.techs.recipe.callbacks.CallbackHome;
import com.seen.techs.recipe.config.AppConfig;
import com.seen.techs.recipe.databases.prefs.AdsPref;
import com.seen.techs.recipe.databases.prefs.SharedPref;
import com.seen.techs.recipe.models.Category;
import com.seen.techs.recipe.models.Recipe;
import com.seen.techs.recipe.rests.RestAdapter;
import com.seen.techs.recipe.utils.AdsManager;
import com.seen.techs.recipe.utils.Constant;
import com.seen.techs.recipe.utils.RtlViewPager;
import com.seen.techs.recipe.utils.Tools;
import com.facebook.shimmer.ShimmerFrameLayout;
import com.google.android.material.tabs.TabLayout;

import java.util.List;
import java.util.Objects;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class FragmentHome extends Fragment {

    private View root_view;
    private SwipeRefreshLayout swipe_refresh;
    private Call<CallbackHome> callbackCall = null;
    private View lyt_main_content;
    private Runnable runnableCode = null;
    private Handler handler = new Handler();
    private ViewPager view_pager_featured;
    private RtlViewPager view_pager_featured_rtl;
    public static final String EXTRA_OBJC = "key.EXTRA_OBJC";
    private ShimmerFrameLayout lyt_shimmer;
    SharedPref sharedPref;
    AdsPref adsPref;
    AdsManager adsManager;

    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        if (AppConfig.RTL_MODE) {
            root_view = inflater.inflate(R.layout.fragment_home_rtl, container, false);
        } else {
            root_view = inflater.inflate(R.layout.fragment_home, container, false);
        }

        sharedPref = new SharedPref(getActivity());
        adsPref = new AdsPref(getActivity());
        adsManager = new AdsManager(getActivity());
        adsManager.loadNativeAdFragment(root_view, NATIVE_AD_HOME);

        swipe_refresh = root_view.findViewById(R.id.swipe_refresh);
        swipe_refresh.setColorSchemeResources(R.color.colorPrimary);
        lyt_main_content = root_view.findViewById(R.id.lyt_home_content);
        lyt_shimmer = root_view.findViewById(R.id.shimmer_view_container);

        // on swipe list
        swipe_refresh.setOnRefreshListener(this::requestAction);

        requestAction();

        return root_view;
    }

    private void requestAction() {
        showFailedView(false, "");
        swipeProgress(true);
        new Handler().postDelayed(this::requestHomeData, Constant.DELAY_TIME);
    }

    private void requestHomeData() {
        this.callbackCall = RestAdapter.createAPI(sharedPref.getApiUrl()).getHome(AppConfig.REST_API_KEY);
        this.callbackCall.enqueue(new Callback<CallbackHome>() {
            public void onResponse(Call<CallbackHome> call, Response<CallbackHome> response) {
                CallbackHome responseHome = response.body();
                if (responseHome == null || !responseHome.status.equals("ok")) {
                    onFailRequest();
                    return;
                }
                displayData(responseHome);
                swipeProgress(false);
                lyt_main_content.setVisibility(View.VISIBLE);
            }

            public void onFailure(Call<CallbackHome> call, Throwable th) {
                Log.e("onFailure", th.getMessage());
                if (!call.isCanceled()) {
                    onFailRequest();
                }
            }
        });
    }

    private void onFailRequest() {
        swipeProgress(false);
        if (Tools.isConnect(getActivity())) {
            showFailedView(true, getString(R.string.failed_text));
        } else {
            showFailedView(true, getString(R.string.failed_text));
        }
    }

    private void showFailedView(boolean show, String message) {
        View lyt_failed = root_view.findViewById(R.id.lyt_failed_home);
        ((TextView) root_view.findViewById(R.id.failed_message)).setText(message);
        if (show) {
            lyt_failed.setVisibility(View.VISIBLE);
            lyt_main_content.setVisibility(View.GONE);
        } else {
            lyt_failed.setVisibility(View.GONE);
            lyt_main_content.setVisibility(View.VISIBLE);
        }
        root_view.findViewById(R.id.failed_retry).setOnClickListener(view -> requestAction());
    }

    private void swipeProgress(final boolean show) {
        if (!show) {
            swipe_refresh.setRefreshing(show);
            lyt_shimmer.setVisibility(View.GONE);
            lyt_shimmer.stopShimmer();
            lyt_main_content.setVisibility(View.VISIBLE);

            return;
        }
        swipe_refresh.post(() -> {
            swipe_refresh.setRefreshing(show);
            lyt_shimmer.setVisibility(View.VISIBLE);
            lyt_shimmer.startShimmer();
            lyt_main_content.setVisibility(View.GONE);
        });
    }

    private void startAutoSlider(final int position) {

        if (AppConfig.RTL_MODE) {
            if (this.runnableCode != null) {
                this.handler.removeCallbacks(this.runnableCode);
            }
            this.runnableCode = () -> {
                int currentItem = view_pager_featured_rtl.getCurrentItem() + 1;
                if (currentItem >= position) {
                    currentItem = 0;
                }
                view_pager_featured_rtl.setCurrentItem(currentItem);
                handler.postDelayed(FragmentHome.this.runnableCode, AppConfig.AUTO_SLIDER_DURATION);
            };
            handler.postDelayed(this.runnableCode, AppConfig.AUTO_SLIDER_DURATION);
        } else {
            if (this.runnableCode != null) {
                this.handler.removeCallbacks(this.runnableCode);
            }
            this.runnableCode = () -> {
                int currentItem = view_pager_featured.getCurrentItem() + 1;
                if (currentItem >= position) {
                    currentItem = 0;
                }
                view_pager_featured.setCurrentItem(currentItem);
                handler.postDelayed(FragmentHome.this.runnableCode, AppConfig.AUTO_SLIDER_DURATION);
            };
            handler.postDelayed(this.runnableCode, AppConfig.AUTO_SLIDER_DURATION);
        }

    }

    private void displayData(CallbackHome responseHome) {
        displayFeatured(responseHome.featured);
        displayCategory(responseHome.category);
        displayRecent(responseHome.recent);
        displayVideos(responseHome.videos);
        displayData();
    }

    private void displayData() {

        ((TextView) root_view.findViewById(R.id.txt_title_category)).setText(getResources().getString(R.string.home_title_category));
        ((TextView) root_view.findViewById(R.id.txt_title_recent)).setText(getResources().getString(R.string.home_title_recent));
        ((TextView) root_view.findViewById(R.id.txt_title_videos)).setText(getResources().getString(R.string.home_title_videos));

        ((ImageView) root_view.findViewById(R.id.img_arrow_category)).setImageResource(R.drawable.ic_arrow_next);
        ((ImageView) root_view.findViewById(R.id.img_arrow_recent)).setImageResource(R.drawable.ic_arrow_next);
        ((ImageView) root_view.findViewById(R.id.img_arrow_videos)).setImageResource(R.drawable.ic_arrow_next);

        root_view.findViewById(R.id.ripple_more_category).setOnClickListener(view -> {
            Activity act = getActivity();
            if (act instanceof MainActivity) {
                ((MainActivity) act).selectFragmentCategory();
            }
        });

        root_view.findViewById(R.id.ripple_recent_more).setOnClickListener(view -> {
            Intent intent = new Intent(getActivity(), ActivityRecipeList.class);
            intent.putExtra("title", getResources().getString(R.string.home_title_recent));
            intent.putExtra("filter", 1);
            startActivity(intent);
        });

        root_view.findViewById(R.id.ripple_videos_more).setOnClickListener(view -> {
            Intent intent = new Intent(getActivity(), ActivityRecipeList.class);
            intent.putExtra("title", getResources().getString(R.string.home_title_videos));
            intent.putExtra("filter", 2);
            startActivity(intent);
        });

    }

    private void displayFeatured(final List<Recipe> list) {

        if (AppConfig.RTL_MODE) {
            view_pager_featured_rtl = root_view.findViewById(R.id.view_pager_featured_rtl);
            final AdapterFeatured adapter = new AdapterFeatured(getActivity(), list);
            final LinearLayout lyt_featured = root_view.findViewById(R.id.lyt_featured);
            view_pager_featured_rtl.setAdapter(adapter);
            view_pager_featured_rtl.setOffscreenPageLimit(4);

            if (list.size() > 0) {
                lyt_featured.setVisibility(View.VISIBLE);
            } else {
                lyt_featured.setVisibility(View.GONE);
            }

            view_pager_featured_rtl.addOnPageChangeListener(new ViewPager.SimpleOnPageChangeListener() {

                public void onPageSelected(int position) {
                    super.onPageSelected(position);
                    if (position < list.size()) {

                    }
                }
            });
            adapter.setOnItemClickListener((view, obj) -> {
                Intent intent = new Intent(getActivity(), ActivityRecipeDetail.class);
                intent.putExtra(Constant.EXTRA_OBJC, obj);
                startActivity(intent);
                ((MainActivity) Objects.requireNonNull(getActivity())).showInterstitialAd();
            });

            TabLayout tabLayout = root_view.findViewById(R.id.tabDots);
            tabLayout.setupWithViewPager(view_pager_featured_rtl, true);

            startAutoSlider(list.size());
        } else {
            view_pager_featured = root_view.findViewById(R.id.view_pager_featured);
            final AdapterFeatured adapter = new AdapterFeatured(getActivity(), list);
            final LinearLayout lyt_featured = root_view.findViewById(R.id.lyt_featured);
            view_pager_featured.setAdapter(adapter);
            view_pager_featured.setOffscreenPageLimit(4);

            if (list.size() > 0) {
                lyt_featured.setVisibility(View.VISIBLE);
            } else {
                lyt_featured.setVisibility(View.GONE);
            }

            view_pager_featured.addOnPageChangeListener(new ViewPager.SimpleOnPageChangeListener() {

                public void onPageSelected(int position) {
                    super.onPageSelected(position);
                    if (position < list.size()) {

                    }
                }
            });
            adapter.setOnItemClickListener((view, obj) -> {
                Intent intent = new Intent(getActivity(), ActivityRecipeDetail.class);
                intent.putExtra(Constant.EXTRA_OBJC, obj);
                startActivity(intent);
                ((MainActivity) Objects.requireNonNull(getActivity())).showInterstitialAd();
            });

            TabLayout tabLayout = root_view.findViewById(R.id.tabDots);
            tabLayout.setupWithViewPager(view_pager_featured, true);

            startAutoSlider(list.size());
        }

    }

    private void displayCategory(List<Category> list) {
        RecyclerView recyclerView = root_view.findViewById(R.id.recycler_view_category);
        recyclerView.setLayoutManager(new LinearLayoutManager(getActivity(), LinearLayoutManager.HORIZONTAL, false));
        AdapterHomeCategory adapterHomeCategory = new AdapterHomeCategory(getActivity(), list);
        recyclerView.setAdapter(adapterHomeCategory);
        recyclerView.setNestedScrollingEnabled(false);
        adapterHomeCategory.setOnItemClickListener((view, obj, position) -> {
            Intent intent = new Intent(getActivity(), ActivityCategoryDetail.class);
            intent.putExtra(EXTRA_OBJC, obj);
            startActivity(intent);
            ((MainActivity) Objects.requireNonNull(getActivity())).showInterstitialAd();
        });

        LinearLayout lyt_category = root_view.findViewById(R.id.lyt_category);
        if (list.size() > 0) {
            lyt_category.setVisibility(View.VISIBLE);
        } else {
            lyt_category.setVisibility(View.GONE);
        }
    }

    private void displayRecent(List<Recipe> list) {
        RecyclerView recyclerView = root_view.findViewById(R.id.recycler_view_recent);
        recyclerView.setLayoutManager(new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.HORIZONTAL));
        AdapterHomeRecipes adapterNews = new AdapterHomeRecipes(getActivity(), recyclerView, list);
        recyclerView.setAdapter(adapterNews);
        recyclerView.setNestedScrollingEnabled(false);
        adapterNews.setOnItemClickListener((view, obj, position) -> {
            Intent intent = new Intent(getActivity(), ActivityRecipeDetail.class);
            intent.putExtra(Constant.EXTRA_OBJC, obj);
            startActivity(intent);
            ((MainActivity) Objects.requireNonNull(getActivity())).showInterstitialAd();
        });

        LinearLayout lyt_recipes = root_view.findViewById(R.id.lyt_recipes);
        if (list.size() > 0) {
            lyt_recipes.setVisibility(View.VISIBLE);
        } else {
            lyt_recipes.setVisibility(View.GONE);
        }
    }

    private void displayVideos(List<Recipe> list) {
        RecyclerView recyclerView = root_view.findViewById(R.id.recycler_view_videos);
        recyclerView.setLayoutManager(new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.HORIZONTAL));
        AdapterHomeRecipes adapterNews = new AdapterHomeRecipes(getActivity(), recyclerView, list);
        recyclerView.setAdapter(adapterNews);
        recyclerView.setNestedScrollingEnabled(false);
        adapterNews.setOnItemClickListener((view, obj, position) -> {
            Intent intent = new Intent(getActivity(), ActivityRecipeDetail.class);
            intent.putExtra(Constant.EXTRA_OBJC, obj);
            startActivity(intent);
            ((MainActivity) Objects.requireNonNull(getActivity())).showInterstitialAd();
        });

        LinearLayout lyt_videos = root_view.findViewById(R.id.lyt_videos);
        if (list.size() > 0) {
            lyt_videos.setVisibility(View.VISIBLE);
        } else {
            lyt_videos.setVisibility(View.GONE);
        }
    }

    public void onDestroy() {
        if (!(callbackCall == null || callbackCall.isCanceled())) {
            this.callbackCall.cancel();
        }
        lyt_shimmer.stopShimmer();
        super.onDestroy();
    }

}

