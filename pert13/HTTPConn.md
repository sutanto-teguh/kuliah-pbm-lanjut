Berikut adalah contoh lengkap **Activity Android (Java)** yang menggunakan **EditText** untuk input data dan mengirimkannya ke `insert_myorder.php` melalui `AsyncTask`:

---

### 📱 **1. Layout XML (`activity_main.xml`)**

```xml
<?xml version="1.0" encoding="utf-8"?>
<LinearLayout xmlns:android="http://schemas.android.com/apk/res/android"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:orientation="vertical"
    android:padding="16dp">

    <EditText
        android:id="@+id/editTextItem"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:hint="Masukkan item" />

    <Button
        android:id="@+id/buttonSubmit"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:text="Kirim" />

</LinearLayout>
```

---

### 🧠 **2. Activity Java (`MainActivity.java`)**

```java
public Button buttonSubmit;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        editTextItem = findViewById(R.id.editTextItem);
        buttonSubmit = findViewById(R.id.buttonSubmit);

        buttonSubmit.setOnClickListener(v -> {
            String item = editTextItem.getText().toString().trim();
            if (!item.isEmpty()) {
                new InsertMyOrderTask().execute(item);
            } else {
                Toast.makeText(MainActivity.this, "Item tidak boleh kosong", Toast.LENGTH_SHORT).show();
            }
        });
    }

    private class InsertMyOrderTask extends AsyncTask<String, Void, String> {

        @Override
        protected String doInBackground(String... params) {
            String itemValue = params[0];
            String urlString = "http://yourserver.com/insert_myorder.php"; // Ganti dengan URL kamu

            try {
                URL url = new URL(urlString);
                HttpURLConnection conn = (HttpURLConnection) url.openConnection();

                conn.setRequestMethod("POST");
                conn.setDoOutput(true);
                conn.setDoInput(true);

                OutputStream os = conn.getOutputStream();
                BufferedWriter writer = new BufferedWriter(new OutputStreamWriter(os, "UTF-8"));
                String postData = "item=" + URLEncoder.encode(itemValue, "UTF-8");
                writer.write(postData);
                writer.flush();
                writer.close();
                os.close();

                InputStream is = conn.getInputStream();
                BufferedReader reader = new BufferedReader(new InputStreamReader(is));
                StringBuilder result = new StringBuilder();
                String line;

                while ((line = reader.readLine()) != null) {
                    result.append(line);
                }

                reader.close();
                conn.disconnect();

                return result.toString();

            } catch (Exception e) {
                e.printStackTrace();
                return "{\"sukses\":0,\"error\":\"" + e.getMessage() + "\"}";
            }
        }

        @Override
        protected void onPostExecute(String result) {
            try {
                JSONObject json = new JSONObject(result);
                int sukses = json.getInt("sukses");
                if (sukses == 1) {
                    Toast.makeText(MainActivity.this, "Insert berhasil!", Toast.LENGTH_SHORT).show();
                    editTextItem.setText("");
                } else {
                    Toast.makeText(MainActivity.this, "Insert gagal!", Toast.LENGTH_SHORT).show();
                }
            } catch (JSONException e) {
                Toast.makeText(MainActivity.this, "Error parsing JSON", Toast.LENGTH_SHORT).show();
            }
        }
    }
}
```

---

### ✅ **Tambahan Penting:**
- Tambahkan permission internet di `AndroidManifest.xml`:

```xml
<uses-permission android:name="android.permission.INTERNET" />
```

---

Kalau kamu ingin versi menggunakan **Retrofit** atau **Volley** untuk performa dan kemudahan yang lebih baik, aku bisa bantu juga. Mau lanjut ke versi itu?
