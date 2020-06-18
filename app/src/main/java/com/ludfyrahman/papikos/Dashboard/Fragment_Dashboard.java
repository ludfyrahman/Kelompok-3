package com.ludfyrahman.papikos.Dashboard;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.drawable.RoundedBitmapDrawable;
import androidx.core.graphics.drawable.RoundedBitmapDrawableFactory;
import androidx.fragment.app.Fragment;

import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.request.target.BitmapImageViewTarget;
import com.ludfyrahman.papikos.Akun.Notifikasi;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Kos.Kos;
import com.ludfyrahman.papikos.Kos.Temp.Temp_Kos;
import com.ludfyrahman.papikos.R;

import de.hdodenhof.circleimageview.CircleImageView;

public class Fragment_Dashboard extends Fragment {
    TextView nama, email, selamat_datang;
    CircleImageView profil;
    ImageView notif;
    LinearLayout area, kontrakan, rumahan;
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        View v = inflater.inflate(R.layout.fragment_dashboard, container, false);
        nama = v.findViewById(R.id.nama);
        email = v.findViewById(R.id.email);
        selamat_datang = v.findViewById(R.id.selamat_datang);
        nama.setText(AuthData.getInstance(getContext()).getNama());
        email.setText(AuthData.getInstance(getContext()).getEmail());
        profil = v.findViewById(R.id.profil);
        String[] nama = AuthData.getInstance(getContext()).getNama().split(" ");
        selamat_datang.setText("Selamat Datang, "+nama[0]);
        area = v.findViewById(R.id.area);
        area.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Temp_Kos.getInstance(getContext()).setKategori("1");
                startActivity(new Intent(getContext(), Kos.class));
            }
        });
        notif = v.findViewById(R.id.notif);
        notif.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Notifikasi.class));
            }
        });
        kontrakan = v.findViewById(R.id.kontrakan);
        kontrakan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Temp_Kos.getInstance(getContext()).setKategori("2");
                startActivity(new Intent(getContext(), Kos.class));
            }
        });
        rumahan = v.findViewById(R.id.rumahan);
        rumahan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Temp_Kos.getInstance(getContext()).setKategori("6");
                startActivity(new Intent(getContext(), Kos.class));
            }
        });
        return v;
    }
}