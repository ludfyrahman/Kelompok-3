package com.ludfyrahman.papikos.Other;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;

import com.ludfyrahman.papikos.Akun.Sign_In;
import com.ludfyrahman.papikos.Akun.Sign_Up;
import com.ludfyrahman.papikos.R;

public class Welcome extends AppCompatActivity {
    Button masuk, daftar;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_welcome);
        masuk = findViewById(R.id.masuk);
        daftar = findViewById(R.id.daftar);
        masuk.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getBaseContext(), Sign_In.class));
            }
        });
        daftar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getBaseContext(), Sign_Up.class));
            }
        });
    }
}
