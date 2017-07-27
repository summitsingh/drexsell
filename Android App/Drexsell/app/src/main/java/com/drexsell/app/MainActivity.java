package com.drexsell.app;

import android.support.v7.app.ActionBarActivity;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.content.pm.ResolveInfo;
import android.net.Uri;
import android.os.Build;
import android.support.v7.widget.Toolbar;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.view.KeyEvent;
import android.app.ProgressDialog;
import android.text.SpannableString;
import android.text.style.ForegroundColorSpan;
import android.view.Menu;
import android.view.MenuItem;
import android.webkit.DownloadListener;
import android.webkit.WebSettings;

import java.util.List;


public class MainActivity extends AppCompatActivity {

    public static final String SITE_NAME = "Drexsell";

    public static final String BASE_URL = "https://www.drexsell.com/index.php";
    public static final boolean TOOLBAR_WANTED = true;
    public static final boolean BACK_ICON_WANTED = true;

    public static final String FACEBOOK_URL = "https://www.facebook.com/drexsellofficial/";

    public static final String TWITTER_ID = "here";
    public static final String TWITTER_URL = "https://twitter.com/MyDrexsell/";

    public static final String LINKEDIN_URL = "here";

    public static final String EMAIL_ADDRESS = "admin@drexsell.com";

    private Toolbar toolbar;
    HTML5WebView mWebView;

    public static ProgressDialog progressDialog;

    public void stopProgressDialog() {
        if (!progressDialog.isShowing()) {
            return;
        }
        try {
            progressDialog.dismiss();
        } catch (Exception ex) {
        }
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);


        progressDialog = ProgressDialog.show(this, null, "Just a second...", true, false);
        String message = "Just a second...";
        SpannableString ss1 = new SpannableString(message);
        ss1.setSpan(new ForegroundColorSpan(getResources().getColor(R.color.primary_dark)), 0, ss1.length(), 0);
        progressDialog.setMessage(ss1);

        mWebView = new HTML5WebView(this);

        if (savedInstanceState != null) {
            mWebView.restoreState(savedInstanceState);
        } else {
            mWebView.loadUrl(BASE_URL);
        }

        setContentView(mWebView.getLayout());


        if (android.os.Build.VERSION.SDK_INT >= Build.VERSION_CODES.HONEYCOMB) {
            mWebView.getSettings().setDisplayZoomControls(false);
        }

        mWebView.setDownloadListener(new DownloadListener() {
            public void onDownloadStart(String url, String userAgent,
                                        String contentDisposition, String mimetype,
                                        long contentLength) {
                Intent i = new Intent(Intent.ACTION_VIEW);
                i.setData(Uri.parse(url));
                startActivity(i);
            }
        });


        if (TOOLBAR_WANTED) {
            toolbar = (Toolbar) findViewById(R.id.app_bar);
            if (toolbar != null) {
                setSupportActionBar(toolbar);


                toolbar.setNavigationIcon(getResources().getDrawable(R.drawable.abc_ic_ab_back_mtrl_am_alpha));
                try {
                    toolbar.getNavigationIcon().setAlpha(0);
                } catch (Exception ex) {
                }

                toolbar.setTitle(SITE_NAME);
            }


        }


    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        switch (id) {
            case R.id.facebook:
                likeFacebook();
                break;
            case R.id.twitter:
                toTwitter();
                break;
            case R.id.email:
                toMail();
                break;
        }

        return super.onOptionsItemSelected(item);
    }

    public void toMail() {
        Intent mailto = new Intent(Intent.ACTION_SEND);
        mailto.setType("message/rfc822"); // use from live device
        mailto.putExtra(Intent.EXTRA_EMAIL, new String[]{EMAIL_ADDRESS});
        mailto.putExtra(Intent.EXTRA_SUBJECT, "Feedback for " + SITE_NAME);
        mailto.putExtra(Intent.EXTRA_TEXT, "");

        startActivity(Intent.createChooser(mailto, "Select an Email Application"));
    }

    public void toTwitter() {
        Intent intent = null;
        try {
            // get the Twitter app if possible
            this.getPackageManager().getPackageInfo("com.twitter.android", 0);
            intent = new Intent(Intent.ACTION_VIEW, Uri.parse("twitter://user?user_id=" + TWITTER_ID));
            intent.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        } catch (Exception e) {
            // no Twitter app, revert to browser
            intent = new Intent(Intent.ACTION_VIEW, Uri.parse(TWITTER_URL));
        }
        this.startActivity(intent);
    }

    public void toLinkedIn() {
        Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(LINKEDIN_URL));
        startActivity(intent);
    }

    public void likeFacebook() {
        String sharerUrl = FACEBOOK_URL;
        Intent intent = new Intent(Intent.ACTION_VIEW, Uri.parse(sharerUrl));

        intent = newFacebookIntent(this);

        startActivity(intent);
    }

    // new method of opening Facebook page to be liked
    public static Intent newFacebookIntent(Context context) {
        String url = FACEBOOK_URL;
        PackageManager pm = context.getPackageManager();
        Uri uri;
        try {
            pm.getPackageInfo("com.facebook.katana", 0);
            // http://stackoverflow.com/a/24547437/1048340
            uri = Uri.parse("fb://facewebmodal/f?href=" + url);
        } catch (PackageManager.NameNotFoundException e) {
            uri = Uri.parse(url);
        }
        return new Intent(Intent.ACTION_VIEW, uri);
    }


    @Override
    public void onSaveInstanceState(Bundle outState) {
        super.onSaveInstanceState(outState);
        mWebView.saveState(outState);
    }

    @Override
    public void onStop() {
        super.onStop();
        mWebView.stopLoading();
    }

    public Toolbar getToolbar() {
        return toolbar;
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {

        if (keyCode == KeyEvent.KEYCODE_BACK) {
            if (mWebView.inCustomView()) {
                mWebView.hideCustomView();
                //  mWebView.goBack();
                //mWebView.goBack();
                return true;
            }

        }
        return super.onKeyDown(keyCode, event);
    }

}

