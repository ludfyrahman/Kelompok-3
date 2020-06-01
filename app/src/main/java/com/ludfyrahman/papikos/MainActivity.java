package com.ludfyrahman.papikos;

import androidx.appcompat.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.WindowManager;
import android.widget.ProgressBar;

import com.google.firebase.iid.FirebaseInstanceId;
import com.ludfyrahman.papikos.Config.MyFirebaseInstanceIdService;
import com.ludfyrahman.papikos.Config.ProgressBarAnimation;

public class MainActivity extends AppCompatActivity {
    ProgressBar progressBar;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        Log.d("token", FirebaseInstanceId.getInstance().getToken());
        progressBar = (ProgressBar)findViewById(R.id.pg);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN, WindowManager.LayoutParams.FLAG_FULLSCREEN);
        progressBar.setMax(100);
        progressBar.setScaleY(3f);
        progressAnimation();
    }
    public void progressAnimation(){
        ProgressBarAnimation anim = new ProgressBarAnimation(this, progressBar, 0f, 100f);
        anim.setDuration(8000);
        progressBar.setAnimation(anim);

    }
}
