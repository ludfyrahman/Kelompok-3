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
import android.widget.LinearLayout;

import com.ludfyrahman.papikos.Akun.Profil;
import com.ludfyrahman.papikos.Akun.Pengaturan.Data_Diri;
import com.ludfyrahman.papikos.Akun.Pengaturan.Form_Rekening;
import com.ludfyrahman.papikos.Akun.Pengaturan.Ubah_Biodata;
import com.ludfyrahman.papikos.Akun.Pengaturan.Ubah_Password;
import com.ludfyrahman.papikos.Akun.Sign_In;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Other.Tentang;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Transaksi.Transaksi;

public class Fragment_Akun extends Fragment {
    LinearLayout profil, edit_profil, edit_password, transaksi, favorit, tentang, keluar;
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        View v = inflater.inflate(R.layout.fragment_akun, container, false);

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
        favorit = v.findViewById(R.id.favorit);
        favorit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Ubah_Password.class));
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
        return v;
    }
}
