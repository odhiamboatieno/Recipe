package com.seen.techs.recipe.callbacks;

import com.seen.techs.recipe.models.Category;
import com.seen.techs.recipe.models.Recipe;

import java.util.ArrayList;
import java.util.List;

public class CallbackCategoryDetail {

    public String status = "";
    public int count = -1;
    public int count_total = -1;
    public int pages = -1;
    public Category category = null;
    public List<Recipe> posts = new ArrayList<>();

}
