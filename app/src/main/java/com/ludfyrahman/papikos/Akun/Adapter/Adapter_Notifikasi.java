package com.ludfyrahman.papikos.Akun.Adapter;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.cardview.widget.CardView;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.ludfyrahman.papikos.Akun.Model.Notifikasi_Model;
import com.ludfyrahman.papikos.Kos.Adapter.Adapter_kos;
import com.ludfyrahman.papikos.Kos.Detail_Kos;
import com.ludfyrahman.papikos.Kos.Model.Kos_Model;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Transaksi.Detail_Transaksi;

import java.util.ArrayList;

public class Adapter_Notifikasi extends RecyclerView.Adapter<Adapter_Notifikasi.ViewHolder> {
    private ArrayList<Notifikasi_Model> listdata;
    private Activity activity;
    private Context context;

    public Adapter_Notifikasi(Activity activity, ArrayList<Notifikasi_Model> listdata, Context context) {
        this.listdata = listdata;
        this.activity = activity;
        this.context = context;
    }

    @Override
    public Adapter_Notifikasi.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.template_notifikasi, parent, false);
        Adapter_Notifikasi.ViewHolder vh = new Adapter_Notifikasi.ViewHolder(v);
        return vh;
    }
    @Override
    public void onBindViewHolder(Adapter_Notifikasi.ViewHolder holder, int position) {
        final Adapter_Notifikasi.ViewHolder x = holder;
        holder.kode.setText(listdata.get(position).getCode());
        holder.title.setText(listdata.get(position).getTitle());
        holder.text.setText(listdata.get(position).getText());
        holder.mContext = context;
        holder.kode.setVisibility(View.GONE);
    }

    @Override
    public int getItemCount() {
        return listdata.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        private CardView cv;
        private TextView kode, title, text;
        ImageView cover;
        Context mContext;

        public ViewHolder(View v) {
            super(v);
            kode = (TextView) v.findViewById(R.id.kode);
            title = (TextView) v.findViewById(R.id.title);
            text = (TextView) v.findViewById(R.id.text);
            v.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    try {
                        Intent intent;
                        intent = new Intent(v.getContext(), Detail_Transaksi.class);
                        intent.putExtra("kode", kode.getText().toString());
                        v.getContext().startActivity(intent);
                    } catch (Exception e) {
                        Log.d("pesan", "error");
                    }
                }
            });
        }
    }
}