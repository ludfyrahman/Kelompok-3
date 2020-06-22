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

import com.ludfyrahman.papikos.Kos.Detail_Kos;
import com.ludfyrahman.papikos.Kos.Model.Fasilitas_Model;
import com.ludfyrahman.papikos.Kos.Model.Type_Model;
import com.ludfyrahman.papikos.R;

import java.util.ArrayList;

public class Adapter_Type extends RecyclerView.Adapter<Adapter_Type.ViewHolder> {
    private ArrayList<Type_Model> listdata;
    private Activity activity;
    private Context context;

    public Adapter_Type(Activity activity, ArrayList<Type_Model> listdata, Context context) {
        this.listdata = listdata;
        this.activity = activity;
        this.context = context;
    }

    @Override
    public Adapter_Type.ViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.template_type, parent, false);
        Adapter_Type.ViewHolder vh = new Adapter_Type.ViewHolder(v);
        return vh;
    }
    @Override
    public void onBindViewHolder(Adapter_Type.ViewHolder holder, int position) {
        final Adapter_Type.ViewHolder x = holder;
        holder.kode.setText(listdata.get(position).getKode());
        holder.type.setText(listdata.get(position).getType());
        holder.id_kos.setText(listdata.get(position).getId_kos());
        holder.mContext = context;
        holder.kode.setVisibility(View.GONE);
    }

    @Override
    public int getItemCount() {
        return listdata.size();
    }

    public static class ViewHolder extends RecyclerView.ViewHolder {
        private CardView cv;
        private TextView kode,type, id_kos;
        ImageView cover;
        Context mContext;

        public ViewHolder(View v) {
            super(v);
            kode = (TextView) v.findViewById(R.id.kode);
            type = (TextView) v.findViewById(R.id.type);
            id_kos = (TextView) v.findViewById(R.id.id_kos);
            v.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {
                    try {
                        Intent intent;
                        intent = new Intent(v.getContext(), Detail_Kos.class);
                        intent.putExtra("kode", id_kos.getText().toString());
                        intent.putExtra("type", kode.getText().toString());
                        v.getContext().startActivity(intent);
                    } catch (Exception e) {
                        Log.d("pesan", "error");
                    }
                }
            });
        }
    }
}

