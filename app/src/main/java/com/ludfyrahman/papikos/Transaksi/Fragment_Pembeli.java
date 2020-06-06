package com.ludfyrahman.papikos.Transaksi;

import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import android.content.Intent;
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

public class Fragment_Pembeli extends Fragment {
    TextView nama, no_hp, email, nama_bank, nama_rekening, no_rekening;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_pembeli, container, false);
        nama = v.findViewById(R.id.nama);
        no_hp = v.findViewById(R.id.no_hp);
        email = v.findViewById(R.id.email);
        nama_bank = v.findViewById(R.id.nama_bank);
        nama_rekening = v.findViewById(R.id.nama_rekening);
        no_rekening = v.findViewById(R.id.no_rekening);
        loadJson();
        return v;
    }
    private void loadJson()
    {
        Log.d("pesan", getArguments().getString("kode"));
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.TRANSAKSI+"detail/"+getArguments().getString("kode"), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    res = new JSONObject(response);
                    JSONObject data = res.getJSONObject("data");
                    nama.setText(data.getString("nama"));
                    no_hp.setText(data.getString("no_hp"));
                    email.setText(data.getString("email"));
                    nama_bank.setText(data.getString("nama_bank"));
                    nama_rekening.setText(data.getString("nama_rekening"));
                    no_rekening.setText(data.getString("no_rekening"));
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
