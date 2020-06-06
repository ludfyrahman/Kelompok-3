package com.ludfyrahman.papikos.Transaksi.Adapter;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import androidx.cardview.widget.CardView;
import androidx.recyclerview.widget.RecyclerView;

import com.bumptech.glide.Glide;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Kos.Adapter.Adapter_kos;
import com.ludfyrahman.papikos.Kos.Detail_Kos;
import com.ludfyrahman.papikos.Kos.Model.Kos_Model;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Transaksi.Detail_Transaksi;
import com.ludfyrahman.papikos.Transaksi.Model.Transaksi_Model;

import java.util.ArrayList;

public class Adapter_Transaksi extends RecyclerView.Adapter<Adapter_Transaksi.ViewHolder> {
    private ArrayList<Transaksi_Model> listdata;
    private Activity activity;
    private Context context;

    public Adapter_Transaksi(Activity activity, ArrayList<Transaksi_Model> listdata, Context context) {
        this.listdata = listdata;
        this.activity = activity;
        this.context = context;
    }

    @Override
    public Adapter_Transaksi.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.template_transaksi, parent, false);
        Adapter_Transaksi.ViewHolder vh = new Adapter_Transaksi.ViewHolder(v);
        return vh;
    }
    @Override
    public void onBindViewHolder(Adapter_Transaksi.ViewHolder holder, int position) {
        final Adapter_Transaksi.ViewHolder x = holder;
        holder.kode.setText(listdata.get(position).getKode());
        holder.kode_transaksi.setText(listdata.get(position).getKode_transaksi());
        holder.kos.setText(listdata.get(position).getKos());
        holder.harga.setText(listdata.get(position).getHarga());
        holder.tanggal.setText(listdata.get(position).getTanggal());
        holder.status.setText(ServerAccess.transaksi(Integer.parseInt(listdata.get(position).getStatus())));
        if (listdata.get(position).getStatus().equals("0")){
            holder.status.setBackgroundResource(R.drawable.button_round_red);
        }else if (listdata.get(position).getStatus().equals("1")){
            holder.status.setBackgroundResource(R.drawable.button_round_orange);
        }else if (listdata.get(position).getStatus().equals("2")){
            holder.status.setBackgroundResource(R.drawable.button_round_blue);
        }else if (listdata.get(position).getStatus().equals("3")){
            holder.status.setBackgroundResource(R.drawable.button_border_blue);
            holder.status.setTextColor(Color.parseColor("#1E58B6"));
        }
        holder.mContext = context;
        holder.kode.setVisibility(View.GONE);
    }

    @Override
    public int getItemCount() {
        return listdata.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        private CardView cv;
        private TextView kode, kode_transaksi, kos, harga, tanggal;
        ImageView cover;
        Button status;
        Context mContext;

        public ViewHolder(View v) {
            super(v);
            kode = (TextView) v.findViewById(R.id.kode);
            kode_transaksi = (TextView) v.findViewById(R.id.kode_transaksi);
            kos = (TextView) v.findViewById(R.id.kos);
            harga = (TextView) v.findViewById(R.id.harga);
            tanggal = (TextView) v.findViewById(R.id.tanggal);
            status = v.findViewById(R.id.status);
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

