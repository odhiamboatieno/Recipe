package com.seen.techs.recipe.callbacks;

import com.seen.techs.recipe.models.Category;
import com.seen.techs.recipe.models.Recipe;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

public class CallbackHome implements Serializable {

    public String status = "";
    public List<Recipe> featured = new ArrayList<>();
    public List<Category> category = new ArrayList<>();
    public List<Recipe> recent = new ArrayList<>();
    public List<Recipe> videos = new ArrayList<>();

}
