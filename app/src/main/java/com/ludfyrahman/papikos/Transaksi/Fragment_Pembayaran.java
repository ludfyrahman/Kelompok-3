package com.ludfyrahman.papikos.Transaksi;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Kos.Detail_Kos;
import com.ludfyrahman.papikos.R;

import org.json.JSONException;
import org.json.JSONObject;

public class Fragment_Pembayaran extends Fragment {
    Button bayar;
    String kode = "", status_code = "1";
    int jumlah = 0;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_pembayaran, container, false);
        bayar = v.findViewById(R.id.bayar);
        bayar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
//                startActivity(new Intent(getContext(), Konfirmasi_Pembayaran.class));
                Intent intent;
                intent = new Intent(v.getContext(), Konfirmasi_Pembayaran.class);
                intent.putExtra("kode", kode);
                intent.putExtra("jumlah", Integer.toString(jumlah));
                intent.putExtra("status", status_code);
                v.getContext().startActivity(intent);
            }
        });
        loadJson();
        return v;
    }
    private void loadJson()
    {
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.TRANSAKSI+"detail/"+getArguments().getString("kode"), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    res = new JSONObject(response);
                    JSONObject data = res.getJSONObject("data");
                    kode = data.getString("id");
                    status_code = data.getString("status_code");
                    if(data.getString("status_code").equals("1")){
                        jumlah = data.getInt("harga") * 25 /100;
//                    nama_kos.setText(data.getString("nama_kos"))
                    }
                    if(data.getString("status_code").equals("3")){
                        bayar.setVisibility(View.GONE);
                    }
//                    tipe.setText(data.getString("type"));
//                    harga.setText(ServerAccess.numberConvert(data.getString("harga")));
//                    jenis.setText(ServerAccess.jenis(data.getInt("jenis")));
//                    kategori.setText(data.getString("kategori"));
//                    nama_bank.setText(data.getString("nama_bank_kos"));
//                    nama_rekening.setText(data.getString("nama_rekening_kos"));
//                    no_rekening.setText(data.getString("no_rekening_kos"));
                } catch (JSONException e) {
                    e.printStackTrace();
                }
            }
        },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.d("volley", "errornya : " + error.getMessage());
                    }
                });
        AppController.getInstance().addToRequestQueue(senddata);
    }
}