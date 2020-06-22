package com.ludfyrahman.papikos.Dashboard;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.MenuItem;
import android.view.View;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.firebase.iid.FirebaseInstanceId;
import com.ludfyrahman.papikos.Akun.Sign_In;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Kos.Temp.Temp_Kos;
import com.ludfyrahman.papikos.R;

public class Dashboard extends AppCompatActivity implements BottomNavigationView.OnNavigationItemSelectedListener{
    BottomNavigationView navigation;
    FloatingActionButton home;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_dashboard);
        navigation = findViewById(R.id.navigation);
        Log.d("token", FirebaseInstanceId.getInstance().getToken());
        navigation.setOnNavigationItemSelectedListener(Dashboard.this);
        navigation.setSelectedItemId(R.id.dashboard);
        loadFragment(new Fragment_Dashboard());
        home = (FloatingActionButton)findViewById(R.id.home);
        home.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                navigation.setSelectedItemId(R.id.dashboard);
                loadFragment(new Fragment_Dashboard());
            }
        });
        Temp_Kos.getInstance(getBaseContext()).clear();
    }
    private boolean loadFragment(Fragment fragment) {
        //switching fragment
        if (fragment != null) {
            getSupportFragmentManager()
                    .beginTransaction()
                    .replace(R.id.container, fragment)
                    .commit();
            return true;
        }
        return false;
    }
    @Override
    public void onBackPressed() {
        new AlertDialog.Builder(this)
                .setIcon(R.drawable.logo)
                .setTitle("Keluar Akun")
                .setMessage("Apakah Anda Yakin Ingin Keluar Dari Akun Ini ?")
                .setPositiveButton("Ya", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        AuthData.getInstance(getBaseContext()).logout();
                        startActivity(new Intent(getBaseContext(), Sign_In.class));
                    }
                })
                .setNegativeButton("Tidak", null)
                .show();
    }
    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem menuItem) {
        Fragment fragment = null;
        MenuItem beranda, umkm, pemesanan, akun;
        beranda = navigation.getMenu().findItem(R.id.dashboard);
//        umkm = navigation.getMenu().findItem(R.id.menuUMKM);
//        pemesanan = navigation.getMenu().findItem(R.id.menuPemesanan);
//        akun = navigation.getMenu().findItem(R.id.menuAkun);
        switch (menuItem.getItemId()) {
            case R.id.dashboard:
                beranda.setTitle("Beranda");
                fragment = new Fragment_Dashboard();
                break;
            case R.id.favorit:
                fragment = new Fragment_Favorit();
                break;
            case R.id.kos:
                fragment = new Fragment_Kos();
                break;
            case R.id.map:
                fragment = new Fragment_Map();
                break;
            case R.id.akun:
                fragment = new Fragment_Akun();
                break;

        }
        return loadFragment(fragment);
    }

    @Override
    public void onPointerCaptureChanged(boolean hasCapture) {

    }

}
