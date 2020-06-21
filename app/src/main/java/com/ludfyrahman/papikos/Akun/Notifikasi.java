package com.ludfyrahman.papikos.Akun;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.app.ProgressDialog;
import android.content.Intent;
import android.location.Address;
import android.location.Geocoder;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.LinearLayout;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.ludfyrahman.papikos.Akun.Adapter.Adapter_Notifikasi;
import com.ludfyrahman.papikos.Akun.Model.Notifikasi_Model;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Kos.Adapter.Adapter_kos;
import com.ludfyrahman.papikos.Kos.Model.Kos_Model;
import com.ludfyrahman.papikos.Kos.Temp.Temp_Kos;
import com.ludfyrahman.papikos.R;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

public class Notifikasi extends AppCompatActivity {
    private Adapter_Notifikasi adapter;
    private List<Notifikasi_Model> list;
    private RecyclerView listdata;
    RecyclerView.LayoutManager mManager;
    ProgressDialog pd;
    LinearLayout not_found;
    SwipeRefreshLayout swLayout;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_notifikasi);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
//        setSupportActionBar(toolbar);
        toolbar.setNavigationIcon(R.drawable.back);
        Intent data = getIntent();
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        listdata = (RecyclerView) findViewById(R.id.listdata);
        listdata.setHasFixedSize(true);
        list = new ArrayList<>();
        adapter = new Adapter_Notifikasi(this,(ArrayList<Notifikasi_Model>) list, this);
        mManager = new LinearLayoutManager(this,LinearLayoutManager.VERTICAL,false);
        listdata.setLayoutManager(mManager);
        listdata.setAdapter(adapter);
        pd = new ProgressDialog(this);
        not_found = findViewById(R.id.not_found);
        swLayout = (SwipeRefreshLayout) findViewById(R.id.swlayout);
        swLayout.setColorSchemeResources(R.color.colorPrimary,R.color.colorPrimaryDark);
        swLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
            @Override
            public void onRefresh() {
                reload();
            }
        });
        loadJson();
    }
    public void reload(){
        not_found.setVisibility(View.GONE);
        list.clear();
        loadJson(); // your code
        listdata.getAdapter().notifyDataSetChanged();
        swLayout.setRefreshing(false);
    }
    private void loadJson()
    {
        pd.setMessage("Menampilkan Data");
        pd.setCancelable(false);
        pd.show();
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.auth+"notifikasi/"+ AuthData.getInstance(getBaseContext()).getId_user(), new Response.Listener<String>() {
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
                                Notifikasi_Model md = new Notifikasi_Model();
                                md.setCode(data.getString("code"));
                                md.setTitle(data.getString("title"));
                                md.setText(data.getString("text"));
                                list.add(md);
                            } catch (Exception ea) {
                                ea.printStackTrace();

                            }
                        }

                        adapter.notifyDataSetChanged();
                        pd.cancel();
                    }else{
                        not_found.setVisibility(View.VISIBLE);
                        pd.cancel();
                    }
                } catch (JSONException e) {
                    e.printStackTrace();
                    pd.cancel();
                }
            }
        },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.d("volley", "errornya : " + error.getMessage());
                        pd.cancel();
                    }
                });

        AppController.getInstance().addToRequestQueue(senddata);
    }
}
