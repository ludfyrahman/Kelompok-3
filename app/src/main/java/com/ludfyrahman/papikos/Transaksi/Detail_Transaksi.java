package com.ludfyrahman.papikos.Transaksi;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.fragment.app.Fragment;
import androidx.viewpager.widget.ViewPager;

import android.app.ProgressDialog;
import android.content.Intent;
import android.location.Address;
import android.location.Geocoder;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.google.android.material.tabs.TabLayout;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.SectionsPagerAdapter;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Config.SliderUtils;
import com.ludfyrahman.papikos.Config.slider.ViewPagerAdapter;
import com.ludfyrahman.papikos.Kos.Detail_Kos;
import com.ludfyrahman.papikos.R;
import com.ludfyrahman.papikos.Ulasan.Model.Ulasan_Model;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.HashMap;
import java.util.List;
import java.util.Locale;
import java.util.Map;

public class Detail_Transaksi extends AppCompatActivity {
    private SectionsPagerAdapter mSectionsPagerAdapter;
    private ViewPager mViewPager;
    ProgressDialog pd;
    TabLayout tabLayout;
    TextView due_date,invoice, tagihan;
    Button status;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_detail_transaksi);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        pd = new ProgressDialog(Detail_Transaksi.this);
        toolbar.setNavigationIcon(R.drawable.back_filled);

        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        mSectionsPagerAdapter = new SectionsPagerAdapter(getSupportFragmentManager());
        // Set up the ViewPager with the sections adapter.
        mViewPager = (ViewPager) findViewById(R.id.container);
        mViewPager.setAdapter(mSectionsPagerAdapter);
        tabLayout= (TabLayout) findViewById(R.id.tabs);
        mViewPager.addOnPageChangeListener(new TabLayout.TabLayoutOnPageChangeListener(tabLayout));
        tabLayout.addOnTabSelectedListener(new TabLayout.ViewPagerOnTabSelectedListener(mViewPager));
        due_date = findViewById(R.id.due_date);
        invoice = findViewById(R.id.invoice);
        tagihan = findViewById(R.id.tagihan);
        status = findViewById(R.id.status);
        setupViewPager(mViewPager);
        loadJson();
    }
    private void loadJson()
    {
        pd.setMessage("Menampilkan Data");
        pd.setCancelable(false);
        pd.show();
        final Intent data = getIntent();
        Log.d("kode_transaksi",data.getStringExtra("kode"));
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.TRANSAKSI+"detail/"+data.getStringExtra("kode"), new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    pd.cancel();
                    res = new JSONObject(response);
                    JSONObject data = res.getJSONObject("data");
                    due_date.setText(data.getString("tanggal_expired"));
                    invoice.setText(ServerAccess.INV+ data.getString("id"));
                    tagihan.setText(ServerAccess.numberConvert(data.getString("harga")));
                    status.setText(data.getString("status"));
                } catch (JSONException e) {
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
    private void setupViewPager(final ViewPager viewPager) {
        Intent data = getIntent();
        Bundle bundle = new Bundle();
        Fragment_Pembeli fp = new Fragment_Pembeli();
        bundle.putString("kode", data.getStringExtra("kode"));
        fp.setArguments(bundle);

        Bundle bi = new Bundle();
        Fragment_Item fi = new Fragment_Item();
        bi.putString("kode", data.getStringExtra("kode"));
        fi.setArguments(bi);

        Bundle bpem = new Bundle();
        Fragment_Pembayaran fpem = new Fragment_Pembayaran();
        bpem.putString("kode", data.getStringExtra("kode"));
        fpem.setArguments(bpem);
        mSectionsPagerAdapter.addFragment(fp, "Pembeli", 0);
        mSectionsPagerAdapter.addFragment(fi, "Item", 1);
        mSectionsPagerAdapter.addFragment(fpem, "PEMBAYARAN", 2);
        viewPager.setAdapter(mSectionsPagerAdapter);
        mSectionsPagerAdapter.notifyDataSetChanged();
        tabLayout.setupWithViewPager(viewPager);

    }
}
