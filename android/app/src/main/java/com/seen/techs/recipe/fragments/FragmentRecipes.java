package com.seen.techs.recipe.fragments;

import static com.seen.techs.recipe.utils.Constant.FILTER_SHOW_ALL_RECIPES;
import static com.seen.techs.recipe.utils.Constant.FILTER_SHOW_ONLY_RECIPES_POSTS;
import static com.seen.techs.recipe.utils.Constant.FILTER_SHOW_ONLY_RECIPES_VIDEOS;
import static com.seen.techs.recipe.utils.Constant.RECIPES_GRID_2_COLUMN;
import static com.seen.techs.recipe.utils.Constant.RECIPES_GRID_3_COLUMN;
import static com.seen.techs.recipe.utils.Constant.RECIPES_LIST_BIG;
import static com.seen.techs.recipe.utils.Constant.RECIPES_LIST_SMALL;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.RecyclerView;
import androidx.recyclerview.widget.StaggeredGridLayoutManager;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import com.seen.techs.recipe.R;
import com.seen.techs.recipe.activities.ActivityRecipeDetail;
import com.seen.techs.recipe.activities.MainActivity;
import com.seen.techs.recipe.adapters.AdapterRecipes;
import com.seen.techs.recipe.callbacks.CallbackRecipes;
import com.seen.techs.recipe.config.AppConfig;
import com.seen.techs.recipe.databases.prefs.SharedPref;
import com.seen.techs.recipe.models.Recipe;
import com.seen.techs.recipe.rests.ApiInterface;
import com.seen.techs.recipe.rests.RestAdapter;
import com.seen.techs.recipe.utils.Constant;
import com.seen.techs.recipe.utils.ItemOffsetDecoration;
import com.seen.techs.recipe.utils.Tools;
import com.facebook.shimmer.ShimmerFrameLayout;

import java.util.ArrayList;
import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class FragmentRecipes extends Fragment {

    View root_view;
    private RecyclerView recyclerView;
    private AdapterRecipes adapterRecipes;
    private SwipeRefreshLayout swipeRefreshLayout;
    private Call<CallbackRecipes> callbackCall = null;
    private int post_total = 0;
    private int failed_page = 0;
    SharedPref sharedPref;
    private ShimmerFrameLayout lyt_shimmer;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        root_view = inflater.inflate(R.layout.fragment_recipes, container, false);

        sharedPref = new SharedPref(getActivity());
        sharedPref.setDefaultFilterRecipes(0);

        setHasOptionsMenu(true);

        lyt_shimmer = root_view.findViewById(R.id.shimmer_view_container);
        swipeRefreshLayout = root_view.findViewById(R.id.swipe_refresh_layout_home);
        swipeRefreshLayout.setColorSchemeResources(R.color.colorPrimary);

        recyclerView = root_view.findViewById(R.id.recyclerView);
        ItemOffsetDecoration itemDecoration = new ItemOffsetDecoration(getActivity(), R.dimen.grid_space_recipes);
        recyclerView.addItemDecoration(itemDecoration);
        if (sharedPref.getRecipesViewType() == RECIPES_LIST_SMALL || sharedPref.getRecipesViewType() == RECIPES_LIST_BIG) {
            recyclerView.setLayoutManager(new StaggeredGridLayoutManager(1, StaggeredGridLayoutManager.VERTICAL));
        } else if (sharedPref.getRecipesViewType() == RECIPES_GRID_3_COLUMN) {
            recyclerView.setLayoutManager(new StaggeredGridLayoutManager(3, StaggeredGridLayoutManager.VERTICAL));
        } else if (sharedPref.getRecipesViewType() == RECIPES_GRID_2_COLUMN) {
            recyclerView.setLayoutManager(new StaggeredGridLayoutManager(2, StaggeredGridLayoutManager.VERTICAL));
        } else {
            recyclerView.setLayoutManager(new StaggeredGridLayoutManager(2, StaggeredGridLayoutManager.VERTICAL));
        }

        recyclerView.setHasFixedSize(true);

        //set data and list adapter
        adapterRecipes = new AdapterRecipes(getActivity(), recyclerView, new ArrayList<>());
        recyclerView.setAdapter(adapterRecipes);

        // on item list clicked
        adapterRecipes.setOnItemClickListener((v, obj, position) -> {
            Intent intent = new Intent(getActivity(), ActivityRecipeDetail.class);
            intent.putExtra(Constant.EXTRA_OBJC, obj);
            startActivity(intent);
            ((MainActivity) getActivity()).showInterstitialAd();
        });

        recyclerView.addOnScrollListener(new RecyclerView.OnScrollListener() {
            @Override
            public void onScrollStateChanged(@NonNull RecyclerView v, int state) {
                super.onScrollStateChanged(v, state);
            }
        });

        adapterRecipes.setOnLoadMoreListener(this::setLoadMore);

        // on swipe list
        swipeRefreshLayout.setOnRefreshListener(() -> {
            if (callbackCall != null && callbackCall.isExecuted()) callbackCall.cancel();
            adapterRecipes.resetListData();
            requestAction(1);
        });

        requestAction(1);
        initShimmerLayout();
        onFilterButtonClickListener();

        return root_view;
    }

    public void setLoadMore(int current_page) {
        Log.d("page", "currentPage: " + current_page);
        // Assuming final total items equal to real post items plus the ad
        int totalItemBeforeAds = (adapterRecipes.getItemCount() - current_page);
        if (post_total > totalItemBeforeAds && current_page != 0) {
            int next_page = current_page + 1;
            requestAction(next_page);
        } else {
            adapterRecipes.setLoaded();
        }
    }

    @Override
    public void onSaveInstanceState(@NonNull Bundle savedInstanceState) {
        super.onSaveInstanceState(savedInstanceState);
    }

    private void displayApiResult(final List<Recipe> videos) {
        adapterRecipes.insertDataWithNativeAd(videos);
        swipeProgress(false);
        if (videos.size() == 0) {
            showNoItemView(true);
        }
    }

    private void requestListPostApi(final int page_no) {

        ApiInterface apiInterface = RestAdapter.createAPI(sharedPref.getApiUrl());

        if (sharedPref.getCurrentFilterRecipes() == 0) {
            callbackCall = apiInterface.getRecipesList(page_no, AppConfig.POST_PER_PAGE, FILTER_SHOW_ALL_RECIPES, AppConfig.REST_API_KEY);
        } else if (sharedPref.getCurrentFilterRecipes() == 1) {
            callbackCall = apiInterface.getRecipesList(page_no, AppConfig.POST_PER_PAGE, FILTER_SHOW_ONLY_RECIPES_POSTS, AppConfig.REST_API_KEY);
        } else if (sharedPref.getCurrentFilterRecipes() == 2) {
            callbackCall = apiInterface.getRecipesList(page_no, AppConfig.POST_PER_PAGE, FILTER_SHOW_ONLY_RECIPES_VIDEOS, AppConfig.REST_API_KEY);
        } else {
            callbackCall = apiInterface.getRecipesList(page_no, AppConfig.POST_PER_PAGE, FILTER_SHOW_ALL_RECIPES, AppConfig.REST_API_KEY);
        }

        callbackCall.enqueue(new Callback<CallbackRecipes>() {
            @Override
            public void onResponse(Call<CallbackRecipes> call, Response<CallbackRecipes> response) {
                CallbackRecipes resp = response.body();
                if (resp != null && resp.status.equals("ok")) {
                    post_total = resp.count_total;
                    displayApiResult(resp.posts);
                } else {
                    onFailRequest(page_no);
                }
            }

            @Override
            public void onFailure(Call<CallbackRecipes> call, Throwable t) {
                if (!call.isCanceled()) onFailRequest(page_no);
            }

        });
    }

    private void onFailRequest(int page_no) {
        failed_page = page_no;
        adapterRecipes.setLoaded();
        swipeProgress(false);
        if (Tools.isConnect(getActivity())) {
            showFailedView(true, getString(R.string.failed_text));
        } else {
            showFailedView(true, getString(R.string.failed_text));
        }
    }

    private void requestAction(final int page_no) {
        showFailedView(false, "");
        showNoItemView(false);
        if (page_no == 1) {
            swipeProgress(true);
        } else {
            adapterRecipes.setLoading();
        }
        new Handler().postDelayed(() -> requestListPostApi(page_no), Constant.DELAY_TIME);
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        swipeProgress(false);
        if (callbackCall != null && callbackCall.isExecuted()) {
            callbackCall.cancel();
        }
        lyt_shimmer.stopShimmer();
    }

    private void showFailedView(boolean show, String message) {
        View lyt_failed = root_view.findViewById(R.id.lyt_failed_home);
        ((TextView) root_view.findViewById(R.id.failed_message)).setText(message);
        if (show) {
            recyclerView.setVisibility(View.GONE);
            lyt_failed.setVisibility(View.VISIBLE);
        } else {
            recyclerView.setVisibility(View.VISIBLE);
            lyt_failed.setVisibility(View.GONE);
        }
        root_view.findViewById(R.id.failed_retry).setOnClickListener(view -> requestAction(failed_page));
    }

    private void showNoItemView(boolean show) {
        View lyt_no_item = root_view.findViewById(R.id.lyt_no_item_home);
        ((TextView) root_view.findViewById(R.id.no_item_message)).setText(R.string.msg_no_item);
        if (show) {
            recyclerView.setVisibility(View.GONE);
            lyt_no_item.setVisibility(View.VISIBLE);
        } else {
            recyclerView.setVisibility(View.VISIBLE);
            lyt_no_item.setVisibility(View.GONE);
        }
    }

    private void swipeProgress(final boolean show) {
        if (!show) {
            swipeRefreshLayout.setRefreshing(show);
            lyt_shimmer.setVisibility(View.GONE);
            lyt_shimmer.stopShimmer();
            return;
        }
        swipeRefreshLayout.post(() -> {
            swipeRefreshLayout.setRefreshing(show);
            lyt_shimmer.setVisibility(View.VISIBLE);
            lyt_shimmer.startShimmer();
        });
    }

    private void onFilterButtonClickListener() {
        MainActivity activity = (MainActivity) getActivity();
        if (activity != null) {
            activity.btn_filter.setOnClickListener(view -> {
                String[] items = getResources().getStringArray(R.array.dialog_filter_list);
                int itemSelected = sharedPref.getCurrentFilterRecipes();
                new AlertDialog.Builder(getActivity())
                        .setTitle(R.string.dialog_title_filter)
                        .setSingleChoiceItems(items, itemSelected, (dialogInterface, position) -> {
                            if (callbackCall != null && callbackCall.isExecuted())
                                callbackCall.cancel();
                            adapterRecipes.resetListData();
                            requestAction(1);
                            sharedPref.updateFilterRecipes(position);
                            dialogInterface.dismiss();
                        })
                        .show();
            });
        }
    }

    private void initShimmerLayout() {
        View lyt_shimmer_recipes_list_small = root_view.findViewById(R.id.lyt_shimmer_recipes_list_small);
        View lyt_shimmer_recipes_list_big = root_view.findViewById(R.id.lyt_shimmer_recipes_list_big);
        View lyt_shimmer_recipes_grid2 = root_view.findViewById(R.id.lyt_shimmer_recipes_grid2);
        View lyt_shimmer_recipes_grid3 = root_view.findViewById(R.id.lyt_shimmer_recipes_grid3);
        if (sharedPref.getRecipesViewType() == RECIPES_LIST_SMALL) {
            lyt_shimmer_recipes_list_small.setVisibility(View.VISIBLE);
            lyt_shimmer_recipes_list_big.setVisibility(View.GONE);
            lyt_shimmer_recipes_grid2.setVisibility(View.GONE);
            lyt_shimmer_recipes_grid3.setVisibility(View.GONE);
        } else if (sharedPref.getRecipesViewType() == RECIPES_LIST_BIG) {
            lyt_shimmer_recipes_list_small.setVisibility(View.GONE);
            lyt_shimmer_recipes_list_big.setVisibility(View.VISIBLE);
            lyt_shimmer_recipes_grid2.setVisibility(View.GONE);
            lyt_shimmer_recipes_grid3.setVisibility(View.GONE);
        } else if (sharedPref.getRecipesViewType() == RECIPES_GRID_2_COLUMN) {
            lyt_shimmer_recipes_list_small.setVisibility(View.GONE);
            lyt_shimmer_recipes_list_big.setVisibility(View.GONE);
            lyt_shimmer_recipes_grid2.setVisibility(View.VISIBLE);
            lyt_shimmer_recipes_grid3.setVisibility(View.GONE);
        } else if (sharedPref.getRecipesViewType() == RECIPES_GRID_3_COLUMN) {
            lyt_shimmer_recipes_list_small.setVisibility(View.GONE);
            lyt_shimmer_recipes_list_big.setVisibility(View.GONE);
            lyt_shimmer_recipes_grid2.setVisibility(View.GONE);
            lyt_shimmer_recipes_grid3.setVisibility(View.VISIBLE);
        }
    }

    @Override
    public void onResume() {
        super.onResume();
        sharedPref.setDefaultFilterRecipes(0);
    }

}
