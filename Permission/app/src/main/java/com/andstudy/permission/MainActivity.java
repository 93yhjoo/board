package com.andstudy.permission;

import android.Manifest;
import android.bluetooth.BluetoothAdapter;
import android.content.Context;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v4.content.ContextCompat;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.TextView;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {

	private MyReceiver receiver;

	@Override
	protected void onDestroy() {
		super.onDestroy();
		this.unregisterReceiver(receiver);
	}

	private TextView textView;
	private LocationManager locationManager;
	private LocationListener locationListener=new LocationListener() {


		@Override
		public void onLocationChanged(Location location) {
			String strLocation="LAT:"+location.getLatitude();
			strLocation+="LNG:"+location.getLongitude();
			textView.setText(strLocation);

		}

		@Override
		public void onStatusChanged(String provider, int status, Bundle extras) {

		}

		@Override
		public void onProviderEnabled(String provider) {

		}

		@Override
		public void onProviderDisabled(String provider) {

		}
	};

	@Override
	public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
		super.onRequestPermissionsResult(requestCode, permissions, grantResults);

		if(requestCode==1001){
			if(grantResults.length>0&&grantResults[0]==PackageManager.PERMISSION_GRANTED){
				initLocationManager();
			}
			else{
				//팝업창 띄우기<short 짧게, longth 길게//
				Toast.makeText(this,"권한필요",Toast.LENGTH_SHORT).show();
			}
		}
	}

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);

		WebView webView=(WebView)findViewById(R.id.webview);
		webView.setWebViewClient(new WebViewClient());
		webView.loadUrl("http://www.naver.com");


		textView=(TextView)findViewById(R.id.textView);
		IntentFilter filter=new IntentFilter(BluetoothAdapter.ACTION_STATE_CHANGED);
		receiver=new MyReceiver();
		this.registerReceiver(receiver,filter);
		if(ContextCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
				== PackageManager.PERMISSION_GRANTED){
			initLocationManager();
		}else{
			ActivityCompat.requestPermissions(this,new String[]{Manifest.permission.ACCESS_FINE_LOCATION},1001);
		}
	}

	private void initLocationManager() {

		locationManager=(LocationManager)getSystemService(Context.LOCATION_SERVICE);
		try{
			locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER,5000,10,locationListener);
		}catch (SecurityException e){
			Toast.makeText(this, "권한이 필요합니다.", Toast.LENGTH_SHORT).show();
		}
	}
}
