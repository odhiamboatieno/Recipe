package com.seen.techs.recipe.databases.prefs;

import static com.seen.techs.recipe.utils.Constant.RECIPES_GRID_2_COLUMN;

import android.content.Context;
import android.content.SharedPreferences;

public class SharedPref {

    private Context context;
    private SharedPreferences sharedPreferences;
    private SharedPreferences.Editor editor;
    private static final String IS_FIRST_TIME_LAUNCH = "IsFirstTimeLaunch";

    public SharedPref(Context context) {
        this.context = context;
        sharedPreferences = context.getSharedPreferences("setting", Context.MODE_PRIVATE);
        editor = sharedPreferences.edit();
    }

    public Boolean getIsDarkTheme() {
        return sharedPreferences.getBoolean("theme", false);
    }

    public void setIsDarkTheme(Boolean isDarkTheme) {
        editor.putBoolean("theme", isDarkTheme);
        editor.apply();
    }

    public void setFirstTimeLaunch(boolean isFirstTime) {
        editor.putBoolean(IS_FIRST_TIME_LAUNCH, isFirstTime);
        editor.commit();
    }

    public boolean isFirstTimeLaunch() {
        return sharedPreferences.getBoolean(IS_FIRST_TIME_LAUNCH, true);
    }

    public void setDefaultFilterRecipes(int i) {
        editor.putInt("filter", i);
        editor.apply();
    }

    public Integer getCurrentFilterRecipes() {
        return sharedPreferences.getInt("filter", 0);
    }

    public void updateFilterRecipes(int position) {
        editor.putInt("filter", position);
        editor.apply();
    }

    public Integer getRecipesViewType() {
        return sharedPreferences.getInt("recipes_list", RECIPES_GRID_2_COLUMN);
    }

    public void updateRecipesViewType(int position) {
        editor.putInt("recipes_list", position);
        editor.apply();
    }

    public void setYoutubeApiKey() {
        editor.putInt("youtube_api_key", 0);
        editor.apply();
    }

    public void saveConfig(String api_url, String application_id) {
        editor.putString("api_url", api_url);
        editor.putString("application_id", application_id);
        editor.apply();
    }

    public String getApiUrl() {
        return sharedPreferences.getString("api_url", "http://example.com");
    }

    public String getApplicationId() {
        return sharedPreferences.getString("application_id", "com.seen.techs.recipe");
    }

    public void saveCredentials(String youtube_api_key, String fcm_notification_topic, String onesignal_app_id, String more_apps_url) {
        editor.putString("youtube_api_key", youtube_api_key);
        editor.putString("fcm_notification_topic", fcm_notification_topic);
        editor.putString("onesignal_app_id", onesignal_app_id);
        editor.putString("more_apps_url", more_apps_url);
        editor.apply();
    }

    public String getYoutubeAPIKey() {
        return sharedPreferences.getString("youtube_api_key", "0");
    }

    public String getFcmNotificationTopic() {
        return sharedPreferences.getString("fcm_notification_topic", "your_recipes_app_topic");
    }

    public String getOneSignalAppId() {
        return sharedPreferences.getString("onesignal_app_id", "0");
    }

    public String getMoreAppsUrl() {
        return sharedPreferences.getString("more_apps_url", "https://play.google.com/store/apps/developer?id=Solodroid");
    }

}
