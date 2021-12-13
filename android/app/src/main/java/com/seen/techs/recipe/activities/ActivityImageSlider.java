package com.seen.techs.recipe.activities;

import static com.seen.techs.recipe.config.AppConfig.RTL_MODE;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.View;
import android.widget.ImageButton;
import android.widget.TextView;

import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.viewpager.widget.ViewPager;

import com.seen.techs.recipe.R;
import com.seen.techs.recipe.adapters.AdapterImageSlider;
import com.seen.techs.recipe.callbacks.CallbackRecipeDetail;
import com.seen.techs.recipe.databases.prefs.SharedPref;
import com.seen.techs.recipe.models.Images;
import com.seen.techs.recipe.rests.RestAdapter;
import com.seen.techs.recipe.utils.Tools;

import java.util.List;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

public class ActivityImageSlider extends AppCompatActivity {

    private Call<CallbackRecipeDetail> callbackCall = null;
    ImageButton btn_close;
    TextView txt_number;
    ViewPager viewPager;
    String recipe_id;
    int position;
    SharedPref sharedPref;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        Tools.getTheme(this);
        setContentView(R.layout.activity_image_slider);
        Tools.getLayoutDirections(this, RTL_MODE);
        sharedPref = new SharedPref(this);

        btn_close = findViewById(R.id.lyt_close);
        btn_close.setOnClickListener(view -> finish());

        txt_number = findViewById(R.id.txt_number);

        Intent intent = getIntent();
        if (null != intent) {
            position = intent.getIntExtra("position", 0);
            recipe_id = intent.getStringExtra("recipe_id");
        }

        requestAction();
        initToolbar();

    }

    private void requestAction() {
        showFailedView(false, "");
        requestPostData();
    }

    private void requestPostData() {
        this.callbackCall = RestAdapter.createAPI(sharedPref.getApiUrl()).getRecipeDetail(recipe_id);
        this.callbackCall.enqueue(new Callback<CallbackRecipeDetail>() {
            public void onResponse(Call<CallbackRecipeDetail> call, Response<CallbackRecipeDetail> response) {
                CallbackRecipeDetail responseHome = response.body();
                if (responseHome == null || !responseHome.status.equals("ok")) {
                    onFailRequest();
                    return;
                }
                displayAllData(responseHome);
            }

            public void onFailure(Call<CallbackRecipeDetail> call, Throwable th) {
                Log.e("onFailure", th.getMessage());
                if (!call.isCanceled()) {
                    onFailRequest();
                }
            }
        });
    }

    private void onFailRequest() {
        if (Tools.isConnect(ActivityImageSlider.this)) {
            showFailedView(true, getString(R.string.failed_text));
        } else {
            showFailedView(true, getString(R.string.failed_text));
        }
    }

    private void showFailedView(boolean show, String message) {
        View lyt_failed = findViewById(R.id.lyt_failed_home);
        ((TextView) findViewById(R.id.failed_message)).setText(message);
        if (show) {
            lyt_failed.setVisibility(View.VISIBLE);
        } else {
            lyt_failed.setVisibility(View.GONE);
        }
        findViewById(R.id.failed_retry).setOnClickListener(view -> requestAction());
    }

    private void displayAllData(CallbackRecipeDetail responseHome) {
        displayImages(responseHome.images);
    }

    private void displayImages(final List<Images> list) {

        viewPager = findViewById(R.id.view_pager_image);
        final AdapterImageSlider adapter = new AdapterImageSlider(ActivityImageSlider.this, list);

        viewPager.setAdapter(adapter);
        viewPager.setOffscreenPageLimit(4);
        viewPager.setCurrentItem(position);

        viewPager.addOnPageChangeListener(new ViewPager.SimpleOnPageChangeListener() {

            public void onPageSelected(final int position) {
                super.onPageSelected(position);
                txt_number.setText((position + 1) + " of " + list.size());
            }

        });

        if (RTL_MODE) {
            viewPager.setRotationY(180);
        }

        txt_number.setText((position + 1) + " of " + list.size());

    }

    private void initToolbar() {
        final Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        final ActionBar actionBar = getSupportActionBar();
        if (actionBar != null) {
            getSupportActionBar().setTitle("");
        }
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    public void onDestroy() {
        if (!(callbackCall == null || callbackCall.isCanceled())) {
            this.callbackCall.cancel();
        }
        super.onDestroy();
    }


}
