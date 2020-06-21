package com.ludfyrahman.papikos.Dashboard;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.graphics.drawable.RoundedBitmapDrawable;
import androidx.core.graphics.drawable.RoundedBitmapDrawableFactory;
import androidx.fragment.app.Fragment;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;
import androidx.swiperefreshlayout.widget.SwipeRefreshLayout;

import android.app.ProgressDialog;
import android.content.Intent;
import android.graphics.Bitmap;
import android.location.Address;
import android.location.Geocoder;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.bumptech.glide.Glide;
import com.bumptech.glide.request.target.BitmapImageViewTarget;
import com.ludfyrahman.papikos.Akun.Notifikasi;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Kos.Adapter.Adapter_Kos_Terbaru;
import com.ludfyrahman.papikos.Kos.Adapter.Adapter_kos;
import com.ludfyrahman.papikos.Kos.Kos;
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

import de.hdodenhof.circleimageview.CircleImageView;

public class Fragment_Dashboard extends Fragment {
    TextView nama, email, selamat_datang;
    CircleImageView profil;
    ImageView notif;
    LinearLayout area, kontrakan, rumahan;

    private Adapter_kos adapter;
    private List<Kos_Model> list_rekom;
    private RecyclerView listdata_rekom;
    RecyclerView.LayoutManager mManager;
    ProgressDialog pd;
    LinearLayout not_found_rekom;

    private Adapter_Kos_Terbaru adapter_terbaru;
    private List<Kos_Model> list_terbaru;
    private RecyclerView listdata_terbaru;
    RecyclerView.LayoutManager mManager_terbaru;
    LinearLayout not_found_terbaru;


    @Override
    public View onCreateView(@NonNull LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        View v = inflater.inflate(R.layout.fragment_dashboard, container, false);
        nama = v.findViewById(R.id.nama);
        email = v.findViewById(R.id.email);
        pd = new ProgressDialog(getContext());
        selamat_datang = v.findViewById(R.id.selamat_datang);
        nama.setText(AuthData.getInstance(getContext()).getNama());
        email.setText(AuthData.getInstance(getContext()).getEmail());
        profil = v.findViewById(R.id.profil);
        String[] nama = AuthData.getInstance(getContext()).getNama().split(" ");
        selamat_datang.setText("Selamat Datang, "+nama[0]);
        area = v.findViewById(R.id.area);
        area.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Temp_Kos.getInstance(getContext()).setKategori("1");
                startActivity(new Intent(getContext(), Kos.class));
            }
        });
        notif = v.findViewById(R.id.notif);
        notif.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getContext(), Notifikasi.class));
            }
        });
        kontrakan = v.findViewById(R.id.kontrakan);
        kontrakan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Temp_Kos.getInstance(getContext()).setKategori("2");
                startActivity(new Intent(getContext(), Kos.class));
            }
        });
        rumahan = v.findViewById(R.id.rumahan);
        rumahan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Temp_Kos.getInstance(getContext()).setKategori("6");
                startActivity(new Intent(getContext(), Kos.class));
            }
        });


        listdata_rekom = (RecyclerView) v.findViewById(R.id.list_rekom);
        listdata_rekom.setHasFixedSize(true);
        list_rekom = new ArrayList<>();
        adapter = new Adapter_kos(getActivity(),(ArrayList<Kos_Model>) list_rekom, getContext());
        mManager = new LinearLayoutManager(getContext(),LinearLayoutManager.HORIZONTAL,false);
        listdata_rekom.setLayoutManager(mManager);
        listdata_rekom.setAdapter(adapter);
        pd = new ProgressDialog(getContext());
        not_found_rekom = v.findViewById(R.id.not_found_rekom);


        listdata_terbaru = (RecyclerView) v.findViewById(R.id.list_terbaru);
        listdata_terbaru.setHasFixedSize(true);
        list_terbaru = new ArrayList<>();
        adapter_terbaru = new Adapter_Kos_Terbaru(getActivity(),(ArrayList<Kos_Model>) list_terbaru, getContext());
        mManager_terbaru = new LinearLayoutManager(getContext(),LinearLayoutManager.HORIZONTAL,false);
        listdata_terbaru.setLayoutManager(mManager_terbaru);
        listdata_terbaru.setAdapter(adapter_terbaru);
        not_found_terbaru = v.findViewById(R.id.not_found_terbaru);
//        swLayout = (SwipeRefreshLayout) findViewById(R.id.swlayout);
//        swLayout.setColorSchemeResources(R.color.colorPrimary,R.color.colorPrimaryDark);
//        swLayout.setOnRefreshListener(new SwipeRefreshLayout.OnRefreshListener() {
//            @Override
//            public void onRefresh() {
//                reload();
//            }
//        });
        Glide.with(getActivity())
                .load(ServerAccess.COVER+"profil/"+ AuthData.getInstance(getContext()).getFoto())
                .into(profil);
        loadJson();
        return v;
    }
    private void loadJson()
    {
        pd.setMessage("Menampilkan Data");
        pd.setCancelable(false);
        pd.show();
        StringRequest senddata = new StringRequest(Request.Method.GET, ServerAccess.DASHBOARD, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                JSONObject res = null;
                try {
                    res = new JSONObject(response);
                    JSONArray arr = res.getJSONArray("rekomended");
                    if(arr.length() > 0) {
                        for (int i = 0; i < arr.length(); i++) {
                            try {
                                JSONObject data = arr.getJSONObject(i);
                                Kos_Model md = new Kos_Model();
                                md.setKode(data.getString("id"));
                                md.setNama(data.getString("nama"));
                                md.setHarga(ServerAccess.numberConvert(data.getString("harga")));
                                Geocoder geocoder = new Geocoder(getActivity(), Locale.getDefault());
                                List<Address> addresses = geocoder.getFromLocation(data.getDouble("latitude"), data.getDouble("longitude"), 1);
                                String cityName = addresses.get(0).getAddressLine(0);
                                md.setAlamat(cityName);
                                md.setCover(ServerAccess.COVER+"kos/"+data.getString("link_media"));
                                list_rekom.add(md);
                            } catch (Exception ea) {
                                ea.printStackTrace();
                            }
                        }

                        adapter.notifyDataSetChanged();
                        pd.cancel();
                    }else{
                        not_found_rekom.setVisibility(View.VISIBLE);
                        pd.cancel();
                    }
                    JSONArray arr_terbaru = res.getJSONArray("terbaru");
                    if(arr_terbaru.length() > 0) {
                        for (int i = 0; i < arr_terbaru.length(); i++) {
                            try {
                                JSONObject data_terbaru = arr_terbaru.getJSONObject(i);
                                Kos_Model md_terbaru = new Kos_Model();
                                md_terbaru.setKode(data_terbaru.getString("id"));
                                Log.d("kos terbaru", data_terbaru.getString("nama"));
                                md_terbaru.setNama(data_terbaru.getString("nama"));
                                md_terbaru.setHarga(ServerAccess.numberConvert(data_terbaru.getString("harga")));
                                md_terbaru.setCover(ServerAccess.COVER+"kos/"+data_terbaru.getString("link_media"));
                                list_terbaru.add(md_terbaru);
                            } catch (Exception ea) {
                                ea.printStackTrace();
                            }
                        }
                        adapter_terbaru.notifyDataSetChanged();
                    }else{
                        not_found_terbaru.setVisibility(View.VISIBLE);
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
                }) ;

        AppController.getInstance().addToRequestQueue(senddata);
    }
}