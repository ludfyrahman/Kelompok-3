package com.ludfyrahman.papikos.Kos;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.viewpager.widget.ViewPager;

import android.app.ProgressDialog;
import android.content.Intent;
import android.location.Address;
import android.location.Geocoder;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Config.SliderUtils;
import com.ludfyrahman.papikos.Config.slider.CustomVolleyRequest;
import com.ludfyrahman.papikos.Config.slider.ViewPagerAdapter;
import com.ludfyrahman.papikos.Kos.Adapter.Adapter_kos;
import com.ludfyrahman.papikos.Kos.Model.Kos_Model;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Ulasan.Adapter.Adapter_Ulasan;
import com.ludfyrahman.papikos.Ulasan.Model.Ulasan_Model;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.Locale;

public class Detail_Kos extends AppCompatActivity {
    TextView nama, harga, lokasi, kategori, jumlah_kamar, jenis, deskripsi, nama_pemilik, no_hp, email;
    ProgressDialog pd;
    String[] sampleImages = new String[4];
    ViewPager viewPager;
    LinearLayout sliderDotspanel, ulasan_not_found;
    private int dotscount;
    private ImageView[] dots;
    RequestQueue rq;
    List<SliderUtils> sliderImg;
    ViewPagerAdapter viewPagerAdapter;

    private Adapter_Ulasan adapter;
    private List<Ulasan_Model> list;
    private RecyclerView listdata;
    RecyclerView.LayoutManager mManager;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_kos);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
//        setSupportActionBar(toolbar);
        toolbar.setNavigationIcon(R.drawable.back_filled);
        pd = new ProgressDialog(Detail_Kos.this);
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        nama = findViewById(R.id.nama);
        harga = findViewById(R.id.harga);
        lokasi = findViewById(R.id.lokasi);
        kategori = findViewById(R.id.kategori);
        jumlah_kamar = findViewById(R.id.kamar);
        deskripsi = findViewById(R.id.deskripsi);
        nama_pemilik = findViewById(R.id.nama_pemilik);
        no_hp = findViewById(R.id.no_hp);
        email = findViewById(R.id.email);
        jenis = findViewById(R.id.jenis);
        ulasan_not_found = findViewById(R.id.ulasan_not_found);
        rq = CustomVolleyRequest.getInstance(this).getRequestQueue();

        sliderImg = new ArrayList<>();

        viewPager = (ViewPager) findViewById(R.id.viewPager);

        sliderDotspanel = (LinearLayout) findViewById(R.id.SliderDots);

        listdata = (RecyclerView) findViewById(R.id.listdata);
        listdata.setHasFixedSize(true);
        list = new ArrayList<>();
        adapter = new Adapter_Ulasan(this,(ArrayList<Ulasan_Model>) list, this);
        mManager = new LinearLayoutManager(this,LinearLayoutManager.HORIZONTAL,false);
        listdata.setLayoutManager(mManager);
        listdata.setAdapter(adapter);


        viewPager.addOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {

            }

            @Override
            public void onPageSelected(int position) {

//                for(int i = 0; i< dotscount; i++){
//                    dots[i].setImageDrawable(ContextCompat.getDrawable(getApplicationContext(), R.drawable.nonactive_dot));
//                }
//
//                dots[position].setImageDrawable(ContextCompat.getDrawable(getApplicationContext(), R.drawable.active_dot));

            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });
        loadJson();
    }
    private void loadJson()
    {
        pd.setMessage("Menampilkan Data");
        pd.setCancelable(false);
        pd.show();
        final Intent data = getIntent();
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.KOS+"detail/"+data.getStringExtra("kode"), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    pd.cancel();
                    res = new JSONObject(response);
                    JSONObject data = res.getJSONObject("data");
                    nama.setText(data.getString("nama_kos"));
                    harga.setText(ServerAccess.numberConvert(data.getString("harga")));
                    kategori.setText(data.getString("kategori"));
                    jumlah_kamar.setText(data.getString("jumlah_kamar"));
                    jenis.setText(ServerAccess.jenis(data.getInt("jenis")));
                    deskripsi.setText(data.getString("deskripsi"));
                    nama_pemilik.setText(data.getString("nama"));
                    no_hp.setText(data.getString("no_hp"));
                    email.setText(data.getString("email"));
                    Geocoder geocoder = new Geocoder(getBaseContext(), Locale.getDefault());
                    List<Address> addresses = geocoder.getFromLocation(data.getDouble("latitude"), data.getDouble("longitude"), 1);
                    String cityName = addresses.get(0).getAddressLine(0);
                    lokasi.setText(cityName);
                    JSONArray arr = data.getJSONArray("media");
                    for (int i = 0; i < arr.length(); i++) {
                        try {
                            JSONObject d = arr.getJSONObject(i);
                            SliderUtils sliderUtils = new SliderUtils();
                            sliderUtils.setSliderImageUrl(ServerAccess.COVER+"kos/"+d.getString("link_media"));
                            sliderImg.add(sliderUtils);
                        } catch (Exception ea) {
                            ea.printStackTrace();

                        }
                    }

                    JSONArray ul = data.getJSONArray("ulasan");
                    if(ul.length() > 0) {
                        for (int i = 0; i < ul.length(); i++) {
                            try {
                                JSONObject ulasan = ul.getJSONObject(i);
                                Ulasan_Model md = new Ulasan_Model();
                                md.setKode(ulasan.getString("id"));
                                md.setNama(ulasan.getString("nama"));
                                md.setUlasan(ulasan.getString("ulasan"));
                                md.setFoto(ServerAccess.COVER+"profil/"+ulasan.getString("profil"));
                                list.add(md);
                            } catch (Exception ea) {
                                ea.printStackTrace();
                            }
                        }

                        adapter.notifyDataSetChanged();
                        pd.cancel();
                    }else{
                        ulasan_not_found.setVisibility(View.VISIBLE);
                        pd.cancel();
                    }
                    viewPagerAdapter = new ViewPagerAdapter(sliderImg, Detail_Kos.this);
//
                    viewPager.setAdapter(viewPagerAdapter);

                    dotscount = viewPagerAdapter.getCount();
                    dots = new ImageView[dotscount];

                    for(int i = 0; i < dotscount; i++){

                        dots[i] = new ImageView(Detail_Kos.this);

                        LinearLayout.LayoutParams params = new LinearLayout.LayoutParams(LinearLayout.LayoutParams.WRAP_CONTENT, LinearLayout.LayoutParams.WRAP_CONTENT);

                        params.setMargins(8, 0, 8, 0);

                        sliderDotspanel.addView(dots[i], params);

                    }

                } catch (JSONException | IOException e) {
                    e.printStackTrace();
                    pd.cancel();
                }
            }
        },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        pd.cancel();
                        Log.d("volley", "errornya : " + error.getMessage());
                    }
                });
        AppController.getInstance().addToRequestQueue(senddata);
    }
}
