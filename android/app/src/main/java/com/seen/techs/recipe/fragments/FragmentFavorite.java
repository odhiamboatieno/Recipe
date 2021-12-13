package com.seen.techs.recipe.fragments;

import static com.seen.techs.recipe.utils.Constant.RECIPES_GRID_2_COLUMN;
import static com.seen.techs.recipe.utils.Constant.RECIPES_GRID_3_COLUMN;
import static com.seen.techs.recipe.utils.Constant.RECIPES_LIST_BIG;
import static com.seen.techs.recipe.utils.Constant.RECIPES_LIST_SMALL;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentTransaction;
import androidx.recyclerview.widget.GridLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import com.seen.techs.recipe.R;
import com.seen.techs.recipe.activities.ActivityRecipeDetail;
import com.seen.techs.recipe.activities.ActivityRecipeDetailOffline;
import com.seen.techs.recipe.adapters.AdapterFavorite;
import com.seen.techs.recipe.databases.prefs.SharedPref;
import com.seen.techs.recipe.databases.sqlite.DbHandler;
import com.seen.techs.recipe.models.Recipe;
import com.seen.techs.recipe.utils.Constant;
import com.seen.techs.recipe.utils.ItemOffsetDecoration;
import com.seen.techs.recipe.utils.Tools;

import java.util.ArrayList;
import java.util.List;

public class FragmentFavorite extends Fragment {

    private List<Recipe> data = new ArrayList<>();
    View root_view;
    AdapterFavorite mAdapterFavorite;
    DbHandler databaseHandler;
    RecyclerView recyclerView;
    LinearLayout linearLayout;
    SharedPref sharedPref;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        root_view = inflater.inflate(R.layout.fragment_favorite, container, false);

        sharedPref = new SharedPref(getActivity());
        databaseHandler = new DbHandler(getActivity());

        linearLayout = root_view.findViewById(R.id.lyt_no_favorite);
        recyclerView = root_view.findViewById(R.id.recyclerView);

        ItemOffsetDecoration itemDecoration = new ItemOffsetDecoration(getActivity(), R.dimen.grid_space_recipes);
        recyclerView.addItemDecoration(itemDecoration);

        if (sharedPref.getRecipesViewType() == RECIPES_LIST_SMALL || sharedPref.getRecipesViewType() == RECIPES_LIST_BIG) {
            recyclerView.setLayoutManager(new GridLayoutManager(getActivity(), 1));
        } else if (sharedPref.getRecipesViewType() == RECIPES_GRID_3_COLUMN) {
            recyclerView.setLayoutManager(new GridLayoutManager(getActivity(), 3));
        } else if (sharedPref.getRecipesViewType() == RECIPES_GRID_2_COLUMN) {
            recyclerView.setLayoutManager(new GridLayoutManager(getActivity(), 2));
        } else {
            recyclerView.setLayoutManager(new GridLayoutManager(getActivity(), 2));
        }

        loadDataFromDatabase();

        return root_view;
    }

    @Override
    public void onActivityCreated(Bundle savedInstanceState) {
        super.onActivityCreated(savedInstanceState);
    }

    @Override
    public void onResume() {
        super.onResume();
        loadDataFromDatabase();
    }

    private void loadDataFromDatabase() {
        data = databaseHandler.getAllData();
        mAdapterFavorite = new AdapterFavorite(getActivity(), recyclerView, data);
        recyclerView.setAdapter(mAdapterFavorite);

        if (data.size() == 0) {
            linearLayout.setVisibility(View.VISIBLE);
        } else {
            linearLayout.setVisibility(View.INVISIBLE);
        }

        mAdapterFavorite.setOnItemClickListener((view, obj, position) -> {
            if (Tools.isConnect(getActivity())) {
                Intent intent = new Intent(getActivity(), ActivityRecipeDetail.class);
                intent.putExtra(Constant.EXTRA_OBJC, obj);
                startActivity(intent);
            } else {
                Intent intent = new Intent(getActivity(), ActivityRecipeDetailOffline.class);
                intent.putExtra(Constant.EXTRA_OBJC, obj);
                startActivity(intent);
            }
        });
    }

    public void refreshFragment() {
        FragmentTransaction fragmentTransaction = getFragmentManager().beginTransaction();
        fragmentTransaction.detach(this).attach(this).commit();
    }

}
