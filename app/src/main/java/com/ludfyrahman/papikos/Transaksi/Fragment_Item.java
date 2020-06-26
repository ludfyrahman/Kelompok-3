package com.ludfyrahman.papikos.Transaksi;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.R;

import org.json.JSONException;
import org.json.JSONObject;

public class Fragment_Item extends Fragment {
    TextView nama_kos, tipe, harga, jenis, kategori, nama_bank, nama_rekening, no_rekening;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_item, container, false);
        nama_kos = v.findViewById(R.id.nama_kos);
        tipe = v.findViewById(R.id.tipe);
        harga = v.findViewById(R.id.harga);
        jenis = v.findViewById(R.id.jenis);
        kategori = v.findViewById(R.id.kategori);
        nama_bank = v.findViewById(R.id.nama_bank);
        nama_rekening = v.findViewById(R.id.nama_rekening);
        no_rekening = v.findViewById(R.id.no_rekening);
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
                    nama_kos.setText(data.getString("nama_kos"));
                    tipe.setText(data.getString("type"));
                    harga.setText(ServerAccess.numberConvert(data.getString("harga")));
                    jenis.setText(ServerAccess.jenis(data.getInt("jenis")));
                    kategori.setText(data.getString("kategori"));
                    nama_bank.setText(data.getString("nama_bank_kos"));
                    nama_rekening.setText(data.getString("nama_rekening_kos"));
                    no_rekening.setText(data.getString("no_rekening_kos"));
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