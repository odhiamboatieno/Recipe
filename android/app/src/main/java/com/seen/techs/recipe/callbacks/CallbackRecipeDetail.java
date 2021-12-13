package com.seen.techs.recipe.callbacks;

import com.seen.techs.recipe.models.Images;
import com.seen.techs.recipe.models.Recipe;

import java.util.ArrayList;
import java.util.List;

public class CallbackRecipeDetail {

    public String status = "";
    public Recipe post = null;
    public List<Images> images = new ArrayList<>();
    public List<Recipe> related = new ArrayList<>();

}