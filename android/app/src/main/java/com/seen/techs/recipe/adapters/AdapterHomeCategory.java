package com.seen.techs.recipe.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.recyclerview.widget.RecyclerView;

import com.seen.techs.recipe.R;
import com.seen.techs.recipe.config.AppConfig;
import com.seen.techs.recipe.databases.prefs.SharedPref;
import com.seen.techs.recipe.models.Category;
import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class AdapterHomeCategory extends RecyclerView.Adapter<RecyclerView.ViewHolder> {

    private List<Category> items;
    private SharedPref sharedPref;
    private Context context;
    private OnItemClickListener mOnItemClickListener;

    public interface OnItemClickListener {
        void onItemClick(View view, Category obj, int position);
    }

    public void setOnItemClickListener(final OnItemClickListener mItemClickListener) {
        this.mOnItemClickListener = mItemClickListener;
    }

    // Provide a suitable constructor (depends on the kind of dataset)
    public AdapterHomeCategory(Context context, List<Category> items) {
        this.items = items;
        this.context = context;
        this.sharedPref = new SharedPref(context);
    }

    public class OriginalViewHolder extends RecyclerView.ViewHolder {
        // each data item is just a string in this case
        public TextView category_name;
        public TextView recipe_count;
        public ImageView category_image;
        public LinearLayout lyt_parent;

        public OriginalViewHolder(View v) {
            super(v);
            category_name = v.findViewById(R.id.category_name);
            recipe_count = v.findViewById(R.id.video_count);
            category_image = v.findViewById(R.id.category_image);
            lyt_parent = v.findViewById(R.id.lyt_parent);
        }
    }

    @NonNull
    @Override
    public RecyclerView.ViewHolder onCreateViewHolder(@NonNull ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext()).inflate(R.layout.item_home_category, parent, false);
        return new OriginalViewHolder(v);
    }

    // Replace the contents of a view (invoked by the layout manager)
    @Override
    public void onBindViewHolder(@NonNull RecyclerView.ViewHolder holder, final int position) {

        final Category c = items.get(position);
        final OriginalViewHolder vItem = (OriginalViewHolder) holder;

        vItem.category_name.setText(c.category_name);

        if (AppConfig.ENABLE_RECIPE_COUNT_ON_CATEGORY) {
            vItem.recipe_count.setVisibility(View.VISIBLE);
            vItem.recipe_count.setText(c.recipes_count + " " + context.getResources().getString(R.string.recipes_count_text));
        } else {
            vItem.recipe_count.setVisibility(View.GONE);
        }

        Picasso.get()
                .load(sharedPref.getApiUrl() + "/upload/category/" + c.category_image)
                .placeholder(R.drawable.ic_thumbnail)
                .into(vItem.category_image);

        vItem.lyt_parent.setOnClickListener(view -> {
            if (mOnItemClickListener != null) {
                mOnItemClickListener.onItemClick(view, c, position);
            }
        });
    }

    public void setListData(List<Category> items){
        this.items = items;
        notifyDataSetChanged();
    }

    public void resetListData() {
        this.items = new ArrayList<>();
        notifyDataSetChanged();
    }

    // Return the size of your dataset (invoked by the layout manager)
    @Override
    public int getItemCount() {
        return items.size();
    }

}