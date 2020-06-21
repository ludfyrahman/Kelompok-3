package com.ludfyrahman.papikos.Akun;

import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.widget.Button;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.firebase.ui.auth.AuthUI;
import com.firebase.ui.auth.IdpResponse;
import com.google.android.gms.auth.api.signin.GoogleSignIn;
import com.google.android.gms.auth.api.signin.GoogleSignInAccount;
import com.google.android.gms.auth.api.signin.GoogleSignInClient;
import com.google.android.gms.auth.api.signin.GoogleSignInOptions;
import com.google.android.gms.common.api.ApiException;
import com.google.android.gms.tasks.Task;
import com.google.firebase.auth.FirebaseAuth;
import com.google.firebase.auth.FirebaseUser;
import com.ludfyrahman.papikos.Config.AppController;
import com.ludfyrahman.papikos.Config.AuthData;
import com.ludfyrahman.papikos.Config.ServerAccess;
import com.ludfyrahman.papikos.Dashboard.Dashboard;
import com.ludfyrahman.papikos.R;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class Auth_Page extends AppCompatActivity {
    TextView daftar;
    Button masuk;
    ProgressDialog pd;
    EditText email, password;
    GoogleSignInClient mGoogleSignInClient;
    int RC_SIGN_IN = 0;
    public static final int MY_REQUEST_CODE = 7117;
    LinearLayout google, facebook;
    List<AuthUI.IdpConfig> providers;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_auth);

        GoogleSignInOptions gso = new GoogleSignInOptions.Builder(GoogleSignInOptions.DEFAULT_SIGN_IN)
                .requestEmail()
                .build();
        mGoogleSignInClient = GoogleSignIn.getClient(this, gso);
        AuthUI.getInstance()
                .signOut(getBaseContext());
        providers = Arrays.asList(
                new AuthUI.IdpConfig.GoogleBuilder().build(),
                new AuthUI.IdpConfig.EmailBuilder().build(),
                new AuthUI.IdpConfig.PhoneBuilder().build(),
                new AuthUI.IdpConfig.FacebookBuilder().build()
        );
        pd = new ProgressDialog(Auth_Page.this);
// Create and launch sign-in intent
        signinOption();
    }
    private void signinOption(){
        startActivityForResult(
                AuthUI.getInstance()
                        .createSignInIntentBuilder()
                        .setAvailableProviders(providers)
                        .setTheme(R.style.LoginTheme)
                        .setLogo(R.drawable.white_logo)
                        .build(),
                MY_REQUEST_CODE);
    }
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        // Result returned from launching the Intent from GoogleSignInClient.getSignInIntent(...);
        if (requestCode == MY_REQUEST_CODE) {
            // The Task returned from this call is always completed, no need to attach
            // a listener.
            IdpResponse response = IdpResponse.fromResultIntent(data);
            if (resultCode == RESULT_OK){
                FirebaseUser user = FirebaseAuth.getInstance().getCurrentUser();
                String name = user.getDisplayName();
                String email = user.getEmail();
                String phone = user.getPhoneNumber();

                if (user.getEmail() != null){
                    LoginEmail(email);
                    Log.d("email", email);
                }else{
                    Log.d("no_hp", phone);
                    LoginPhone(phone);
                }
            }else{
                Toast.makeText(this, ""+response.getError().getMessage(), Toast.LENGTH_SHORT).show();
            }
            Task<GoogleSignInAccount> task = GoogleSignIn.getSignedInAccountFromIntent(data);
            handleSignInResult(task);
        }
    }
    private void LoginEmail(final String email){
        pd.setMessage("Authenticating...");
        pd.setCancelable(false);
        pd.show();
        StringRequest senddata = new StringRequest(Request.Method.POST, ServerAccess.EMAIL, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                pd.cancel();
                try {
                    JSONObject res = new JSONObject(response);
                    if(res.getBoolean("status") == true){
                        JSONObject r = res.getJSONObject("data");
                        AuthData.getInstance(getBaseContext()).setdatauser(r.getString("id"), r.getString("nama"), r.getString("email"), res.getString("token"), r.getString("profil"));
                        Toast.makeText(Auth_Page.this, res.getString("message"), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(getBaseContext(), Dashboard.class);
                        startActivity(intent);
                    }else{
                        Toast.makeText(getBaseContext(), res.getString("msg"), Toast.LENGTH_SHORT).show();
                        startActivity(new Intent(getBaseContext(), Sign_In.class));
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
                params.put("email", email);

                return params;
            }
        };

        AppController.getInstance().addToRequestQueue(senddata);
    }
    private void LoginPhone(final String phone){
        pd.setMessage("Authenticating...");
        pd.setCancelable(false);
        pd.show();
        StringRequest senddata = new StringRequest(Request.Method.POST, ServerAccess.PHONE, new Response.Listener<String>() {
            @Override
            public void onResponse(String response) {
                pd.cancel();
                try {
                    JSONObject res = new JSONObject(response);
                    if(res.getBoolean("status") == true){
                        JSONObject r = res.getJSONObject("data");
                        AuthData.getInstance(getBaseContext()).setdatauser(r.getString("id"), r.getString("nama"), r.getString("email"), res.getString("token"), r.getString("profil"));
                        Toast.makeText(Auth_Page.this, res.getString("message"), Toast.LENGTH_SHORT).show();
                        Intent intent = new Intent(getBaseContext(), Dashboard.class);
                        startActivity(intent);
                    }else{
                        Toast.makeText(getBaseContext(), res.getString("msg"), Toast.LENGTH_SHORT).show();
                        startActivity(new Intent(getBaseContext(), Sign_In.class));
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
                params.put("no_hp", phone);

                return params;
            }
        };

        AppController.getInstance().addToRequestQueue(senddata);
    }
    private void handleSignInResult(Task<GoogleSignInAccount> completedTask) {
        try {
            GoogleSignInAccount account = completedTask.getResult(ApiException.class);

            // Signed in successfully, show authenticated UI.
            GoogleSignInAccount go = GoogleSignIn.getLastSignedInAccount(this);
            if (go != null){
                String name = go.getDisplayName();
                String email = go.getEmail();
                String givenName = go.getGivenName();
                String family = go.getFamilyName();
                Log.d("name", name);
                Log.d("email", email);
                Log.d("givenName", givenName);
                Log.d("family", family);
            }
//            startActivity(new Intent(getBaseContext(), Dashboard.class));
        } catch (ApiException e) {
            // The ApiException status code indicates the detailed failure reason.
            // Please refer to the GoogleSignInStatusCodes class reference for more information.
            Log.w("tag", "signInResult:failed code=" + e.getStatusCode());
//            updateUI(null);
        }
    }
}
