package com.seen.techs.recipe.activities;

import static com.solodroid.ads.sdk.util.Constant.ADMOB;
import static com.solodroid.ads.sdk.util.Constant.AD_STATUS_ON;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Looper;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.ProgressBar;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import com.seen.techs.recipe.BuildConfig;
import com.seen.techs.recipe.R;
import com.seen.techs.recipe.callbacks.CallbackAds;
import com.seen.techs.recipe.config.AppConfig;
import com.seen.techs.recipe.databases.prefs.AdsPref;
import com.seen.techs.recipe.databases.prefs.SharedPref;
import com.seen.techs.recipe.models.Ads;
import com.seen.techs.recipe.rests.RestAdapter;
import com.seen.techs.recipe.utils.Tools;
import com.google.android.gms.ads.FullScreenContentCallback;
import com.solodroid.ads.sdk.format.AppOpenAd;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ActivitySplash extends AppCompatActivity {

    public static final String TAG = "ActivitySplash";
    ProgressBar progressBar;
    ImageView img_splash;
    SharedPref sharedPref;
    AdsPref adsPref;
    Ads ads;
    Call<CallbackAds> callbackCall = null;
    AppOpenAd appOpenAdManager;
    private boolean isAdShown = false;
    private boolean isAdDismissed = false;
    private boolean isLoadCompleted = false;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Tools.getTheme(this);
        setContentView(R.layout.activity_splash);

        sharedPref = new SharedPref(this);
        adsPref = new AdsPref(this);

        img_splash = findViewById(R.id.img_splash);
        if (sharedPref.getIsDarkTheme()) {
            img_splash.setImageResource(R.drawable.bg_splash_dark);
        } else {
            img_splash.setImageResource(R.drawable.bg_splash_default);
        }

        progressBar = findViewById(R.id.progressBar);
        progressBar.setVisibility(View.VISIBLE);

        loadConfig();

    }

    private void requestAds(String apiUrl) {
        this.callbackCall = RestAdapter.createAPI(apiUrl).getAds(AppConfig.REST_API_KEY);
        this.callbackCall.enqueue(new Callback<CallbackAds>() {
            public void onResponse(Call<CallbackAds> call, Response<CallbackAds> response) {
                CallbackAds resp = response.body();
                if (resp != null && resp.status.equals("ok")) {
                    ads = resp.ads;
                    adsPref.saveAds(
                            ads.ad_status.replace("on", "1"),
                            ads.ad_type,
                            ads.admob_publisher_id,
                            ads.admob_app_id,
                            ads.admob_banner_unit_id,
                            ads.admob_interstitial_unit_id,
                            ads.admob_native_unit_id,
                            ads.admob_app_open_ad_unit_id,
                            ads.fan_banner_unit_id,
                            ads.fan_interstitial_unit_id,
                            ads.fan_native_unit_id,
                            ads.startapp_app_id,
                            ads.unity_game_id,
                            ads.unity_banner_placement_id,
                            ads.unity_interstitial_placement_id,
                            ads.applovin_banner_ad_unit_id,
                            ads.applovin_interstitial_ad_unit_id,
                            ads.mopub_banner_ad_unit_id,
                            ads.mopub_interstitial_ad_unit_id,
                            ads.interstitial_ad_interval,
                            ads.native_ad_interval,
                            ads.native_ad_index,
                            ads.date_time
                    );

                    sharedPref.saveCredentials(
                            ads.youtube_api_key,
                            ads.fcm_notification_topic,
                            ads.onesignal_app_id,
                            ads.more_apps_url
                    );

                    Log.d("Response", "Ads Data is saved");
                    onSplashFinished();
                } else {
                    onSplashFinished();
                }
            }

            public void onFailure(Call<CallbackAds> call, Throwable th) {
                Log.e("onFailure", "" + th.getMessage());
                onSplashFinished();
            }
        });
    }

    private void loadConfig() {
        String decode = Tools.decodeBase64(AppConfig.SERVER_KEY);
        String data = Tools.decrypt(decode);
        String[] results = data.split("_applicationId_");
        String apiUrl = results[0].replace("http://localhost", "http://10.0.2.2");
        String applicationId = results[1];
        sharedPref.saveConfig(apiUrl, applicationId);

        if (applicationId.equals(BuildConfig.APPLICATION_ID)) {
            if (Tools.isConnect(this)) {
                requestAds(apiUrl);
            } else {
                launchMainScreen();
            }
        } else {
            new AlertDialog.Builder(this)
                    .setTitle("Error")
                    .setMessage("Whoops! invalid server key or applicationId, please check your configuration")
                    .setPositiveButton(getString(R.string.dialog_ok), (dialog, which) -> finish())
                    .setCancelable(false)
                    .show();
        }
        Log.d(TAG, apiUrl);
        Log.d(TAG, applicationId);
    }

    private void onSplashFinished() {
        if (adsPref.getAdType().equals(ADMOB) && adsPref.getAdStatus().equals(AD_STATUS_ON)) {
            if (!adsPref.getAdMobAppOpenAdId().equals("")) {
                launchAppOpenAd();
            } else {
                launchMainScreen();
            }
        } else {
            launchMainScreen();
        }
    }

    private void launchMainScreen() {
        Intent intent = new Intent(getApplicationContext(), MainActivity.class);
        startActivity(intent);
        new Handler(Looper.getMainLooper()).postDelayed(this::finish, 2000);
    }

    private void launchAppOpenAd() {
        appOpenAdManager = ((MyApplication) getApplication()).getAppOpenAdManager();
        loadResources();
        appOpenAdManager.showAdIfAvailable(adsPref.getAdMobAppOpenAdId(), new FullScreenContentCallback() {

            @Override
            public void onAdShowedFullScreenContent() {
                isAdShown = true;
            }

            @Override
            public void onAdDismissedFullScreenContent() {
                isAdDismissed = true;
                if (isLoadCompleted) {
                    launchMainScreen();
                    Log.d(TAG, "isLoadCompleted and launch main screen...");
                } else {
                    Log.d(TAG, "Waiting resources to be loaded...");
                }
            }
        });
    }

    private void loadResources() {
        new Handler(Looper.getMainLooper()).postDelayed(() -> {
            isLoadCompleted = true;
            // Check whether App Open ad was shown or not.
            if (isAdShown) {
                // Check App Open ad was dismissed or not.
                if (isAdDismissed) {
                    launchMainScreen();
                    Log.d(TAG, "isAdDismissed and launch main screen...");
                } else {
                    Log.d(TAG, "Waiting for ad to be dismissed...");
                }
                Log.d(TAG, "Ad shown...");
            } else {
                launchMainScreen();
                Log.d(TAG, "Ad not shown...");
            }
        }, 200);
    }

}
