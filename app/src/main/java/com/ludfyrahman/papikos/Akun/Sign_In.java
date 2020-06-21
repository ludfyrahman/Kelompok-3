package com.ludfyrahman.papikos.Akun;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.Manifest;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.karumi.dexter.Dexter;
import com.karumi.dexter.MultiplePermissionsReport;
import com.karumi.dexter.PermissionToken;
import com.karumi.dexter.listener.DexterError;
import com.karumi.dexter.listener.PermissionRequest;
import com.karumi.dexter.listener.PermissionRequestErrorListener;
import com.karumi.dexter.listener.multi.MultiplePermissionsListener;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Dashboard.Dashboard;
import com.ludfyrahman.papikos.Other.Welcome;
import com.ludfyrahman.papikos.R;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Sign_In extends AppCompatActivity {
    EditText email, password;
    Button masuk;
    TextView lupa;
    LinearLayout lainnya;
    ProgressDialog pd;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sign_in);
        pd = new ProgressDialog(Sign_In.this);
        pd.setMessage("Please Wait...");
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        toolbar.setNavigationIcon(R.drawable.back);
        Intent data = getIntent();
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getBaseContext(), Welcome.class));
            }
        });
        email = findViewById(R.id.email);
        password = findViewById(R.id.password);
        masuk = findViewById(R.id.masuk);
        lupa = findViewById(R.id.lupa);
        lainnya = findViewById(R.id.lainnya);
        lainnya.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getBaseContext(), Auth_Page.class));
            }
        });
        lupa.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                startActivity(new Intent(getBaseContext(), Lupa_Password.class));
            }
        });
        masuk.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                login();
            }
        });
        requestMultiplePermissions();
    }
    private void requestMultiplePermissions(){

        Dexter.withActivity(this)
                .withPermissions(
                        Manifest.permission.CAMERA,
                        Manifest.permission.WRITE_EXTERNAL_STORAGE,
                        Manifest.permission.ACCESS_FINE_LOCATION,
                        Manifest.permission.READ_EXTERNAL_STORAGE)
                .withListener(new MultiplePermissionsListener() {
                    @Override
                    public void onPermissionsChecked(MultiplePermissionsReport report) {
                        // check if all permissions are granted
                        if (report.areAllPermissionsGranted()) {
//                            Toast.makeText(getApplicationContext(), "All permissions are granted by user!", Toast.LENGTH_SHORT).show();
                        }
                        // check for permanent denial of any permission
                        if (report.isAnyPermissionPermanentlyDenied()) {
                            // show alert dialog navigating to Settings
                            //openSettingsDialog();
                        }
                    }
                    @Override
                    public void onPermissionRationaleShouldBeShown(List<PermissionRequest> permissions, PermissionToken token) {
                        token.continuePermissionRequest();
                    }
                }).
                withErrorListener(new PermissionRequestErrorListener() {
                    @Override
                    public void onError(DexterError error) {
                        Toast.makeText(getApplicationContext(), "Some Error! ", Toast.LENGTH_SHORT).show();
                    }
                })
                .onSameThread()
                .check();
    }
    private void login(){
        pd.setMessage("Authenticating...");
        pd.setCancelable(false);
        pd.show();
        if (email.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Email Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            email.setFocusable(true);
            pd.dismiss();
        }else if (!android.util.Patterns.EMAIL_ADDRESS.matcher(email.getText().toString()).matches()) {
            Toast.makeText(getBaseContext(), "Email Tidak Valid", Toast.LENGTH_LONG).show();
            email.setFocusable(true);
            pd.dismiss();
        }else if (password.getText().toString().isEmpty()) {
            Toast.makeText(getBaseContext(), "Password Tidak Boleh Kosong", Toast.LENGTH_LONG).show();
            password.setFocusable(true);
            pd.dismiss();
        }else{
            Log.d("url", ServerAccess.SIGN_IN);
            StringRequest senddata = new StringRequest(Request.Method.POST, ServerAccess.SIGN_IN, new Response.Listener<String>() {
                @Override
                public void onResponse(String response) {
                    pd.cancel();
                    try {
                        JSONObject res = new JSONObject(response);
                        Log.d("pesan", res.toString());
                        if(res.getBoolean("status") == true){
                            JSONObject r = res.getJSONObject("data");
//                            Log.d("pesan", )
                            AuthData.getInstance(getBaseContext()).setdatauser(r.getString("id"), r.getString("nama"), r.getString("email"), res.getString("token"), r.getString("profil"));
                            Toast.makeText(Sign_In.this, res.getString("message"), Toast.LENGTH_SHORT).show();
                            Intent intent = new Intent(getBaseContext(), Dashboard.class);

                            startActivity(intent);
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
                    params.put("email", email.getText().toString());
                    params.put("password", password.getText().toString());
                    return params;
                }
            };

            AppController.getInstance().addToRequestQueue(senddata);
        }
    }
    @Override
    public void onBackPressed() {
        startActivity(new Intent(getBaseContext(), Welcome.class));
    }
}
