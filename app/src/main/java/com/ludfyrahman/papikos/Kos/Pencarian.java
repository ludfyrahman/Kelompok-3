package com.ludfyrahman.papikos.Kos;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.google.android.material.bottomsheet.BottomSheetDialogFragment;
import com.ludfyrahman.papikos.R;

public class Pencarian extends BottomSheetDialogFragment {
    TextView nama, harga, alamat;
    ImageView cover;
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.activity_pencarian, container, false);
        nama = v.findViewById(R.id.nama);
        harga = v.findViewById(R.id.harga);
        alamat = v.findViewById(R.id.alamat);
        cover = v.findViewById(R.id.cover);
        return v;
    }
}
