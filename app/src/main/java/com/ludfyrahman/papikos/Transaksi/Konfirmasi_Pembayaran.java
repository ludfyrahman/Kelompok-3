package com.ludfyrahman.papikos.Transaksi;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;

import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.Toast;

import com.ludfyrahman.papikos.R;

import java.io.IOException;

public class Konfirmasi_Pembayaran extends AppCompatActivity {
    Bitmap bitmap;
    private ImageView gambar;
    private int GALLERY = 1, CAMERA = 2;
    int image = 1;
    Button upload;
    private Uri contentURI;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_konfirmasi_pembayaran);
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
        upload = findViewById(R.id.upload);
        gambar = findViewById(R.id.gambar);
        upload.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                image = 1;
                showPictureDialog();
            }
        });
        upload.setOnLongClickListener(new View.OnLongClickListener() {
            @Override
            public boolean onLongClick(View v) {
                remove_image(gambar);
                return true;
            }
        });
        gambar.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                image = 1;
                showPictureDialog();
            }
        });
        gambar.setOnLongClickListener(new View.OnLongClickListener() {
            @Override
            public boolean onLongClick(View v) {
                remove_image(gambar);
                return true;
            }
        });
    }
    private void showPictureDialog(){
        AlertDialog.Builder pictureDialog = new AlertDialog.Builder(this);
        pictureDialog.setTitle("Select Action");
        String[] pictureDialogItems = {
                "Select photo from gallery",
                "Capture photo from camera" };
        pictureDialog.setItems(pictureDialogItems,
                new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        switch (which) {
                            case 0:
                                choosePhotoFromGallary();
                                break;
                            case 1:
                                takePhotoFromCamera();
                                break;
                        }
                    }
                });
        pictureDialog.show();
    }
    public void choosePhotoFromGallary() {
        Intent intent = new Intent();
        intent.setType("image/*");
        intent.setAction(Intent.ACTION_GET_CONTENT);
        if (intent.resolveActivity(getPackageManager()) != null) {
            startActivityForResult(Intent.createChooser(intent, "Select Picture"), GALLERY);
        }
    }
    private void takePhotoFromCamera() {
        Intent intent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
        startActivityForResult(intent, CAMERA);
    }
    private void remove_image(final ImageView imageView){
        new AlertDialog.Builder(Konfirmasi_Pembayaran.this)
                .setIcon(R.drawable.logo)
                .setTitle("Hapus Gambar")
                .setMessage("Apakah Anda Yakin Ingin Gambar ?")
                .setPositiveButton("Ya", new DialogInterface.OnClickListener() {
                    @Override
                    public void onClick(DialogInterface dialog, int which) {
                        imageView.setImageResource(R.drawable.bg_default);
                    }
                })
                .setNegativeButton("Tidak", null)
                .show();
    }
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (resultCode == this.RESULT_CANCELED) {
            return;
        }
        if (requestCode == GALLERY) {
            if (data != null) {
                contentURI = data.getData();
                try {
                    bitmap = MediaStore.Images.Media.getBitmap(this.getContentResolver(), contentURI);
                    gambar.setImageBitmap(bitmap);
                    gambar.setVisibility(View.VISIBLE);
                    upload.setVisibility(View.GONE);
                } catch (IOException e) {
                    e.printStackTrace();
                    Toast.makeText(Konfirmasi_Pembayaran.this, "Failed!", Toast.LENGTH_SHORT).show();
                }
            }

        } else if (requestCode == CAMERA) {
            Log.d("active",Integer.toString(image));
            bitmap = (Bitmap) data.getExtras().get("data");
            gambar.setImageBitmap(bitmap);
            gambar.setVisibility(View.VISIBLE);
            upload.setVisibility(View.GONE);
            Toast.makeText(Konfirmasi_Pembayaran.this, "Image Saved!", Toast.LENGTH_SHORT).show();
        }
    }
}
