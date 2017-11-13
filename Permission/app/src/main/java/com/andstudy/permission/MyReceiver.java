package com.andstudy.permission;

import android.bluetooth.BluetoothAdapter;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.widget.Toast;

/**
 * Created by joo on 2017-11-13.
 */

public class MyReceiver extends BroadcastReceiver {
	@Override
	public void onReceive(Context context, Intent intent) {
		int state=intent.getIntExtra(BluetoothAdapter.EXTRA_STATE,-1);
		String strState="";
		switch (state){
			case BluetoothAdapter.STATE_ON:
				strState="ON";break;
			case BluetoothAdapter.STATE_OFF:
				strState="OFF";break;

		}
		Toast.makeText(context,"bt"+strState,Toast.LENGTH_SHORT).show();
	}
}
