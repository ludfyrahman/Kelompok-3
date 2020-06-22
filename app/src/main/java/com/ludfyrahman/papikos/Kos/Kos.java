package com.ludfyrahman.papikos.Kos;

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
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Dashboard.Dashboard;
import com.ludfyrahman.papikos.Kos.Adapter.Adapter_kos;
import com.ludfyrahman.papikos.Kos.Model.Kos_Model;
import com.ludfyrahman.papikos.Kos.Temp.Temp_Kos;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Transaksi.Detail_Transaksi;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

public class Kos extends AppCompatActivity {
    private Adapter_kos adapter;
    private List<Kos_Model> list;
    private RecyclerView listdata;
    RecyclerView.LayoutManager mManager;
    ProgressDialog pd;
    LinearLayout not_found;
    SwipeRefreshLayout swLayout;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_kos);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        toolbar.setNavigationIcon(R.drawable.back);
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayShowTitleEnabled(false);
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
                startActivity(new Intent(getBaseContext(), Dashboard.class));
            }
        });
        listdata = (RecyclerView) findViewById(R.id.listdata);
        listdata.setHasFixedSize(true);
        list = new ArrayList<>();
        adapter = new Adapter_kos(this,(ArrayList<Kos_Model>) list, this);
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
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.filter_menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.filter) {
//            startActivity(new Intent(getBaseContext(), Pencarian.class));
//            Toast.makeText(Kos.this, "Action clicked", Toast.LENGTH_LONG).show();
            Pencarian bt = new Pencarian();
            Bundle bundle = new Bundle();
//            bundle.putString("id", marker.getSnippet());
            bt.setArguments(bundle);
            bt.show(getSupportFragmentManager(), "Kos");
            return true;
        }

        return super.onOptionsItemSelected(item);
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
        StringRequest senddata = new StringRequest(Request.Method.POST, ServerAccess.KOS+"data", new Response.Listener<String>() {
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
                                Kos_Model md = new Kos_Model();
                                md.setKode(data.getString("id"));
                                md.setNama(data.getString("nama"));
                                md.setHarga(ServerAccess.numberConvert(data.getString("harga")));
                                Geocoder geocoder = new Geocoder(getBaseContext(), Locale.getDefault());
                                List<Address> addresses = geocoder.getFromLocation(data.getDouble("latitude"), data.getDouble("longitude"), 1);
                                String cityName = addresses.get(0).getAddressLine(0);
                                String stateName = addresses.get(0).getAddressLine(1);
                                String countryName = addresses.get(0).getAddressLine(2);
//                                Log.d("city", cityName);
                                md.setAlamat(cityName);
                                md.setCover(ServerAccess.COVER+"kos/"+data.getString("link_media"));
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
                }) {
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("search", "1");
                params.put("kategori",Temp_Kos.getKategori());
                params.put("cari", Temp_Kos.getCari());
                params.put("tipe", Temp_Kos.getTipe());
                params.put("urut", Temp_Kos.getUrut());
                params.put("harga_awal", Temp_Kos.getHarga());
                params.put("harga_tertinggi", Temp_Kos.getHarga_tertinggi());
                return params;
            }
        };

        AppController.getInstance().addToRequestQueue(senddata);
    }
}
