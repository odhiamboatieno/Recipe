package com.seen.techs.recipe.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.viewpager.widget.PagerAdapter;

import com.seen.techs.recipe.R;
import com.seen.techs.recipe.databases.prefs.SharedPref;
import com.seen.techs.recipe.models.Recipe;
import com.seen.techs.recipe.utils.Constant;
import com.squareup.picasso.Picasso;

import java.util.List;

public class AdapterFeatured extends PagerAdapter {

    private Context context;
    private List<Recipe> items;
    private SharedPref sharedPref;
    private OnItemClickListener onItemClickListener;

    public interface OnItemClickListener {
        void onItemClick(View view, Recipe video);
    }

    public boolean isViewFromObject(@NonNull View view, @NonNull Object obj) {
        return view == obj;
    }

    public void setOnItemClickListener(OnItemClickListener onItemClickListener) {
        this.onItemClickListener = onItemClickListener;
    }

    public AdapterFeatured(Context context, List<Recipe> list) {
        this.context = context;
        this.sharedPref = new SharedPref(context);
        this.items = list;
    }

    @NonNull
    public Object instantiateItem(ViewGroup viewGroup, int position) {
        final Recipe p = items.get(position);
        View inflate = LayoutInflater.from(viewGroup.getContext()).inflate(R.layout.item_featured, viewGroup, false);

        ImageView image = inflate.findViewById(R.id.image);
        ImageView thumbnail_video = inflate.findViewById(R.id.thumbnail_video);

        if (p.content_type != null && p.content_type.equals("youtube")) {
            Picasso.get()
                    .load(Constant.YOUTUBE_IMAGE_FRONT + p.video_id + Constant.YOUTUBE_IMAGE_BACK_MQ)
                    .placeholder(R.drawable.ic_thumbnail)
                    .into(image);
        } else {
            Picasso.get()
                    .load(sharedPref.getApiUrl() + "/upload/" + p.recipe_image.replace(" ", "%20"))
                    .placeholder(R.drawable.ic_thumbnail)
                    .into(image);
        }

        ((TextView) inflate.findViewById(R.id.recipe_title)).setText(p.recipe_title);
        ((TextView) inflate.findViewById(R.id.category_name)).setText(p.category_name);

        if (p.content_type != null && p.content_type.equals("Post")) {
            thumbnail_video.setVisibility(View.GONE);
        } else {
            thumbnail_video.setVisibility(View.VISIBLE);
        }

        inflate.findViewById(R.id.lyt_parent).setOnClickListener(view -> {
            if (AdapterFeatured.this.onItemClickListener != null) {
                AdapterFeatured.this.onItemClickListener.onItemClick(view, p);
            }
        });

        viewGroup.addView(inflate);
        return inflate;
    }

    public int getCount() {
        return this.items.size();
    }

    public void destroyItem(ViewGroup viewGroup, int i, @NonNull Object obj) {
        viewGroup.removeView((View) obj);
    }

}