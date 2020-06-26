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
import android.widget.TextView;

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
    TextView jumlah_bayar, status, kode_transaksi, total;
    int jumlah = 0;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.fragment_pembayaran, container, false);
        bayar = v.findViewById(R.id.bayar);
        jumlah_bayar = v.findViewById(R.id.jumlah_bayar);
        status = v.findViewById(R.id.status);
        kode_transaksi = v.findViewById(R.id.kode_transaksi);
        total = v.findViewById(R.id.total);
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
                        int hitung =  data.getInt("harga") * 25 /100;
                        jumlah = hitung;
                        jumlah_bayar.setText(ServerAccess.numberConvert(Integer.toString(hitung)));
//                    nama_kos.setText(data.getString("nama_kos"))
                    }else if(data.getString("status_code").equals("2")){
                        int hitung =  data.getInt("harga") - (data.getInt("harga") * 25 /100);
                        jumlah = hitung;
                        jumlah_bayar.setText(ServerAccess.numberConvert(Integer.toString(hitung)));
                    }
                    total.setText(ServerAccess.numberConvert(data.getString("harga")));
                    status.setText(data.getString("status"));
                    kode_transaksi.setText(ServerAccess.INV+data.getString("status_code"));
                    if(data.getString("status_code").equals("3") || data.getString("status_code").equals("0")){
                        bayar.setVisibility(View.GONE);
                    }
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