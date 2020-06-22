package com.ludfyrahman.papikos.Kos;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Intent;
import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Spinner;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.bottomsheet.BottomSheetDialogFragment;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Kos.Temp.Temp_Kos;
import com.ludfyrahman.papikos.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

public class Pencarian extends BottomSheetDialogFragment {
    TextView harga_awal, harga_tertinggi, cari, reset;
    ImageView cover;
    private ArrayList<String> kategorilist, jenislist, urutkanlist;
    Spinner kategori, jenis, urutkan;
    Button terapkan;
    @Nullable
    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        View v = inflater.inflate(R.layout.activity_pencarian, container, false);
        harga_awal = v.findViewById(R.id.harga_awal);
        harga_tertinggi = v.findViewById(R.id.harga_tertinggi);
        cari = v.findViewById(R.id.cari);
        reset = v.findViewById(R.id.reset);
        reset.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Temp_Kos.getInstance(getContext()).clear();
                startActivity(new Intent(getContext(), Kos.class));
            }
        });
        harga_awal.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                Log.d("harga", s.toString());
                Temp_Kos.getInstance(getContext()).setHarga(s.toString());
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });
        harga_tertinggi.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                Log.d("harga tinggi", s.toString());
                Temp_Kos.getInstance(getContext()).setHarga_tertinggi(s.toString());
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });
        cari.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence s, int start, int count, int after) {

            }

            @Override
            public void onTextChanged(CharSequence s, int start, int before, int count) {
                Log.d("cari", s.toString());
                Temp_Kos.getInstance(getContext()).setCari(s.toString());
            }

            @Override
            public void afterTextChanged(Editable s) {

            }
        });
        terapkan = v.findViewById(R.id.terapkan);
        terapkan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Kos.class));
            }
        });
        kategori = v.findViewById(R.id.kategori);
        kategori.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                String val = kategori.getSelectedItem().toString();
                if(val.equals("Kost Area")){
                    Temp_Kos.getInstance(getContext()).setKategori("1");
                }else if(val.equals("Kontrakan")) {
                    Temp_Kos.getInstance(getContext()).setKategori("2");
                }else{
                    Temp_Kos.getInstance(getContext()).setKategori("3");
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
        jenis = v.findViewById(R.id.jenis);
        jenis.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                String val = jenis.getSelectedItem().toString();
                if(val.equals("Laki-laki")){
                    Temp_Kos.getInstance(getContext()).setTipe("1");
                }else{
                    Temp_Kos.getInstance(getContext()).setTipe("2");
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
        kategorilist = new ArrayList<String>();
        kategorilist.add("Kost Area");
        kategorilist.add("Kontrakan");
        kategorilist.add("Kos Rumahan");
        kategori.setAdapter(new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, kategorilist));
        jenislist = new ArrayList<String>();
        urutkanlist = new ArrayList<String>();
        jenislist.add("Laki-laki");
        jenislist.add("Perempuan");
        jenis.setAdapter(new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, jenislist));
        urutkan = v.findViewById(R.id.urutkan);
        urutkan.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {
            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                String val = urutkan.getSelectedItem().toString();
                if(val.equals("Terbaru")){
                    Temp_Kos.getInstance(getContext()).setUrut("1");
                }else if(val.equals("Termurah")){
                    Temp_Kos.getInstance(getContext()).setUrut("2");
                }else{
                    Temp_Kos.getInstance(getContext()).setUrut("3");
                }
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {

            }
        });
        urutkanlist.add("Terbaru");
        urutkanlist.add("Termurah");
        urutkanlist.add("Tertinggi");
        urutkan.setAdapter(new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, urutkanlist));
        if(Temp_Kos.getInstance(getContext()).isExist()){
            cari.setText(Temp_Kos.getCari());
            harga_awal.setText(Temp_Kos.getHarga());
            harga_tertinggi.setText(Temp_Kos.getHarga_tertinggi());
        }
        return v;
    }
    private void loadJson()
    {
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.KATEGORI+"data", new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    res = new JSONObject(response);
                    JSONArray arr = res.getJSONArray("data");
                    if(arr.length() > 0) {
                        for (int i = 0; i < arr.length(); i++) {
                            try {
                                JSONObject data = arr.getJSONObject(i);
                                kategorilist.add(data.getString("nama"));
                            } catch (Exception ea) {
                                ea.printStackTrace();
                            }
                        }
                        kategori.setAdapter(new ArrayAdapter<String>(getActivity(), R.layout.spinner_item, kategorilist));
                    }
                } catch (JSONException e) {
                    Log.d("pesan", "error "+e.getMessage());
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
