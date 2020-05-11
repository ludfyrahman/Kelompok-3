package com.ludfyrahman.papikos.Transaksi;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

import com.ludfyrahman.papikos.R;

public class Fragment_Pembayaran extends Fragment {
    Button bayar;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_pembayaran, container, false);
        bayar = v.findViewById(R.id.bayar);
        bayar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Konfirmasi_Pembayaran.class));
            }
        });
        return v;
    }
}