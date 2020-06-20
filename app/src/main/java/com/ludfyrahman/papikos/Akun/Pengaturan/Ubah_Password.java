package com.ludfyrahman.papikos.Akun.Pengaturan;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.R;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class Ubah_Password extends AppCompatActivity {
    EditText password, password_konfirmasi, old_password;
    ProgressDialog pd;
    Button simpan;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_ubah_password);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        password = findViewById(R.id.password);
        simpan = findViewById(R.id.simpan);
        password_konfirmasi = findViewById(R.id.password_konfirmasi);
        old_password = findViewById(R.id.old_password);
        pd = new ProgressDialog(Ubah_Password.this);
        toolbar.setNavigationIcon(R.drawable.back);
        Intent data = getIntent();
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
            }
        });
        simpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                simpan();
            }
        });
    }
    private void simpan(){
        pd.setMessage("Proses...");
        pd.setCancelable(false);
        pd.show();
        if (password.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Password Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            password.setFocusable(true);
            pd.dismiss();
        }else if (old_password.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Password Lama Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            old_password.setFocusable(true);
            pd.dismiss();
        }else if (password.getText().toString().equals(password_konfirmasi.getText().toString())) {
            Toast.makeText(getBaseContext(), "Password Tidak sama Dengan Password Konfirmasi", Toast.LENGTH_LONG).show();
            password.setFocusable(true);
            pd.dismiss();
        }else{
            StringRequest senddata = new StringRequest(Request.Method.POST, ServerAccess.auth+"update_password", new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    pd.cancel();
                    try {
                        JSONObject res = new JSONObject(response);
                        Log.d("pesan", res.toString());
                        if(res.getBoolean("status") == true){
                            Toast.makeText(Ubah_Password.this, res.getString("message"), Toast.LENGTH_SHORT).show();
                            finish();
                        }else{
                            Toast.makeText(getBaseContext(), res.getString("message"), Toast.LENGTH_SHORT).show();
                        }
                        pd.dismiss();

                    } catch (JSONException e) {
                        e.printStackTrace();
                    }
                }
            }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    pd.cancel();

                    Log.e("errornyaa ", "" + error);
                    Toast.makeText(getBaseContext(), "Gagal Login, "+error, Toast.LENGTH_SHORT).show();


                }
            }){
                @Override
                protected Map<String, String> getParams() throws AuthFailureError {
                    Map<String, String> params = new HashMap<>();
                    params.put("id", AuthData.getInstance(getBaseContext()).getId_user());
                    params.put("password", password.getText().toString());
                    params.put("password_confirmation", password_konfirmasi.getText().toString());
                    params.put("old_password", old_password.getText().toString());
                    return params;
                }
            };

            AppController.getInstance().addToRequestQueue(senddata);
        }
    }
}
