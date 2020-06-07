package com.ludfyrahman.papikos.Config;

import android.content.Context;
import android.content.Intent;
import android.view.animation.Animation;
import android.view.animation.Transformation;
import android.widget.ProgressBar;

import com.google.android.gms.maps.model.Dash;
import com.ludfyrahman.papikos.Akun.Sign_In;
import com.ludfyrahman.papikos.Dashboard.Dashboard;
import com.ludfyrahman.papikos.Dashboard.Fragment_Dashboard;
import com.ludfyrahman.papikos.Dashboard.Fragment_Kos;
import com.ludfyrahman.papikos.Kos.Detail_Kos;
import com.ludfyrahman.papikos.Other.Intro;
import com.ludfyrahman.papikos.Transaksi.Detail_Transaksi;

public class ProgressBarAnimation extends Animation {
    private Context context;
    private ProgressBar progressBar;
    private float from;
    private float to;

    public ProgressBarAnimation(Context context, ProgressBar progressBar, float from, float to){
        this.context = context;
        this.progressBar = progressBar;
        this.from = from;
        this.to = to;
    }
    @Override
    protected void applyTransformation(float interpolatedTime, Transformation t) {
        super.applyTransformation(interpolatedTime, t);
        float value = from + (to - from ) * interpolatedTime;
        progressBar.setProgress((int) value);

        if (value == to){
            context.startActivity(new Intent(context, Intro.class));
//            context.startActivity(new Intent(context, Intro.class));
        }
    }
}