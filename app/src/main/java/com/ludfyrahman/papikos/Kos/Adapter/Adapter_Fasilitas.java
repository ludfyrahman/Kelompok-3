package com.ludfyrahman.papikos.Kos.Adapter;

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
import com.ludfyrahman.papikos.Kos.Detail_Kos;
import com.ludfyrahman.papikos.Kos.Model.Fasilitas_Model;
import com.ludfyrahman.papikos.Kos.Model.Kos_Model;
import com.ludfyrahman.papikos.R;

import java.util.ArrayList;

public class Adapter_Fasilitas extends RecyclerView.Adapter<Adapter_Fasilitas.ViewHolder> {
    private ArrayList<Fasilitas_Model> listdata;
    private Activity activity;
    private Context context;

    public Adapter_Fasilitas(Activity activity, ArrayList<Fasilitas_Model> listdata, Context context) {
        this.listdata = listdata;
        this.activity = activity;
        this.context = context;
    }

    @Override
    public Adapter_Fasilitas.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.template_fasilitas, parent, false);
        Adapter_Fasilitas.ViewHolder vh = new Adapter_Fasilitas.ViewHolder(v);
        return vh;
    }
    @Override
    public void onBindViewHolder(Adapter_Fasilitas.ViewHolder holder, int position) {
        final Adapter_Fasilitas.ViewHolder x = holder;
        holder.kode.setText(listdata.get(position).getKode());
        holder.nama.setText(listdata.get(position).getNama());
        holder.mContext = context;
        holder.kode.setVisibility(View.GONE);
    }

    @Override
    public int getItemCount() {
        return listdata.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        private CardView cv;
        private TextView kode, harga, nama, alamat;
        ImageView cover;
        Context mContext;

        public ViewHolder(View v) {
            super(v);
            kode = (TextView) v.findViewById(R.id.kode);
            nama = (TextView) v.findViewById(R.id.nama);
//            v.setOnClickListener(new View.OnClickListener() {
//                @Override
//                public void onClick(View v) {
//                    try {
//                        Intent intent;
//                        intent = new Intent(v.getContext(), Detail_Kos.class);
//                        intent.putExtra("kode", kode.getText().toString());
//                        v.getContext().startActivity(intent);
//                    } catch (Exception e) {
//                        Log.d("pesan", "error");
//                    }
//                }
//            });
        }
    }
}

