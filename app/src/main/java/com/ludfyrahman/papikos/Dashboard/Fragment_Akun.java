package com.ludfyrahman.papikos.Dashboard;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.ludfyrahman.papikos.Akun.Profil;
import com.ludfyrahman.papikos.Akun.Pengaturan.Data_Diri;
import com.ludfyrahman.papikos.Akun.Pengaturan.Form_Rekening;
import com.ludfyrahman.papikos.Akun.Pengaturan.Ubah_Biodata;
import com.ludfyrahman.papikos.Akun.Pengaturan.Ubah_Password;
import com.ludfyrahman.papikos.Akun.Sign_In;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Other.Tentang;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Transaksi.Transaksi;

public class Fragment_Akun extends Fragment {
    LinearLayout profil, edit_profil, edit_password, transaksi, favorit, tentang, keluar;
    ImageView profil_image;
    TextView email, nama;
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        View v = inflater.inflate(R.layout.fragment_akun, container, false);
        profil_image = v.findViewById(R.id.profil_image);
        email = v.findViewById(R.id.email);
        email.setText(AuthData.getInstance(getContext()).getEmail());
        nama = v.findViewById(R.id.nama);
        nama.setText(AuthData.getInstance(getContext()).getNama());
        profil = v.findViewById(R.id.profil);
        profil.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Profil.class));
            }
        });
        edit_profil = v.findViewById(R.id.edit_profil);
        edit_profil.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Data_Diri.class));
            }
        });
        edit_password = v.findViewById(R.id.edit_password);
        edit_password.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Ubah_Password.class));
            }
        });
        transaksi = v.findViewById(R.id.transaksi);
        transaksi.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Transaksi.class));
            }
        });
        tentang = v.findViewById(R.id.tentang);
        tentang.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Tentang.class));
            }
        });
        keluar = v.findViewById(R.id.keluar);
        keluar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AuthData.getInstance(getContext()).logout();
                startActivity(new Intent(getContext(), Sign_In.class));
            }
        });
        Glide.with(getActivity())
                .load(ServerAccess.COVER+"profil/"+ AuthData.getInstance(getContext()).getFoto())
                .into(profil_image);
        return v;
    }
}
