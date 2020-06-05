package com.ludfyrahman.papikos.Dashboard;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.drawable.RoundedBitmapDrawable;
import androidx.core.graphics.drawable.RoundedBitmapDrawableFactory;
import androidx.fragment.app.Fragment;

import android.graphics.Bitmap;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.request.target.BitmapImageViewTarget;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.R;

import de.hdodenhof.circleimageview.CircleImageView;

public class Fragment_Dashboard extends Fragment {
    TextView nama, email, selamat_datang;
    CircleImageView profil;
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
//        Glide.with(getContext())
//                .load(ServerAccess.COVER+"profil/"+AuthData.getInstance(getContext()).getFoto())
//                .into(profil);
        return v;
    }
}