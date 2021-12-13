package com.seen.techs.recipe.models;

import java.io.Serializable;

public class Recipe implements Serializable {

    public int id;

    public String cat_id;
    public String category_name;

    public String recipe_id;
    public String recipe_title;
    public String recipe_time;
    public String recipe_image;
    public String recipe_description;
    public String video_url;
    public String video_id;
    public String content_type;
    public String featured;
    public String tags;
    public long total_views;

    public Recipe() {
    }

    public Recipe(String recipe_id) {
        this.recipe_id = recipe_id;
    }

    public Recipe(String category_name, String recipe_id, String recipe_title, String recipe_time, String recipe_image, String recipe_description, String video_url, String video_id, String content_type, String featured, String tags, long total_views) {
        this.category_name = category_name;
        this.recipe_id = recipe_id;
        this.recipe_title = recipe_title;
        this.recipe_time = recipe_time;
        this.recipe_image = recipe_image;
        this.recipe_description = recipe_description;
        this.video_url = video_url;
        this.video_id = video_id;
        this.content_type = content_type;
        this.featured = featured;
        this.tags = tags;
        this.total_views = total_views;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getCat_id() {
        return cat_id;
    }

    public void setCat_id(String cat_id) {
        this.cat_id = cat_id;
    }

    public String getCategory_name() {
        return category_name;
    }

    public void setCategory_name(String category_name) {
        this.category_name = category_name;
    }

    public String getRecipe_id() {
        return recipe_id;
    }

    public void setRecipe_id(String recipe_id) {
        this.recipe_id = recipe_id;
    }

    public String getRecipe_title() {
        return recipe_title;
    }

    public void setRecipe_title(String recipe_title) {
        this.recipe_title = recipe_title;
    }

    public String getRecipe_time() {
        return recipe_time;
    }

    public void setRecipe_time(String recipe_time) {
        this.recipe_time = recipe_time;
    }

    public String getRecipe_image() {
        return recipe_image;
    }

    public void setRecipe_image(String recipe_image) {
        this.recipe_image = recipe_image;
    }

    public String getRecipe_description() {
        return recipe_description;
    }

    public void setRecipe_description(String recipe_description) {
        this.recipe_description = recipe_description;
    }

    public String getVideo_url() {
        return video_url;
    }

    public void setVideo_url(String video_url) {
        this.video_url = video_url;
    }

    public String getVideo_id() {
        return video_id;
    }

    public void setVideo_id(String video_id) {
        this.video_id = video_id;
    }

    public String getContent_type() {
        return content_type;
    }

    public void setContent_type(String content_type) {
        this.content_type = content_type;
    }

    public String getFeatured() {
        return featured;
    }

    public void setFeatured(String featured) {
        this.featured = featured;
    }

    public String getTags() {
        return tags;
    }

    public void setTags(String tags) {
        this.tags = tags;
    }

    public long getTotal_views() {
        return total_views;
    }

    public void setTotal_views(long total_views) {
        this.total_views = total_views;
    }

}
