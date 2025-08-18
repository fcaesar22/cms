# 📂 Manual SQL Scripts

Folder ini berisi file-file SQL untuk perubahan struktur dan data database **yang dilakukan secara manual** (tanpa migration bawaan CodeIgniter).

Semua file SQL harus dijalankan **berdasarkan urutan nomor prefix** (001, 002, dst).

---

## 🧾 Daftar SQL & Fungsinya

| No   | File                                                     | Fungsi                                                  |
|------|----------------------------------------------------------|---------------------------------------------------------|
| 001  | 001_create_roles_table.sql                               | Membuat tabel `roles`                                   |
| 002  | 002_insert_default_roles.sql                             | Menambahkan roles default                               |
| 003  | 003_create_permissions_table.sql                         | Membuat tabel `permissions`                             |
| 004  | 004_insert_default_permissions.sql                       | Menambahkan permissions default                         |
| 005  | 005_create_menus_table.sql                               | Membuat tabel `menus`                                   |
| 006  | 006_insert_default_menus.sql                             | Menambahkan menus default                               |
| 007  | 007_create_role_permissions_table.sql                    | Membuat tabel `role_permissions`                        |
| 008  | 008_insert_default_role_permissions.sql                  | Menambahkan role_permissions default                    |
| 009  | 009_create_menu_permissions_table.sql                    | Membuat tabel `menu_permissions`                        |
| 010  | 010_insert_default_menu_permissions.sql                  | Menambahkan menu_permissions default                    |
| 011  | 011_create_users_table.sql                               | Membuat tabel `users`                                   |
| 012  | 012_insert_default_users.sql                             | Menambahkan users default                               |
| 013  | 013_create_category_whatson_table.sql                    | Membuat tabel `category_whatson`                        |
| 014  | 014_create_sub_category_whatson_table.sql                | Membuat tabel `sub_category_whatson`                    |
| 015  | 015_create_channel_whatson_table.sql                     | Membuat tabel `channel_whatson`                         |
| 016  | 016_create_thumbnail_whatson_table.sql                   | Membuat tabel `thumbnail_whatson`                       |
| 017  | 017_create_whatson_table.sql                             | Membuat tabel `whatson`                                 |
| 018  | 018_create_whatson_content_table.sql                     | Membuat tabel `whatson_content`                         |
| 019  | 019_create_client_app_table.sql                          | Membuat tabel `client_app`                              |
| 020  | 020_create_genre_tv_table.sql                            | Membuat tabel `genre_tv`                                |
| 021  | 021_create_tv_channel_table.sql                          | Membuat tabel `tv_channel`                              |
| 022  | 022_create_mng_code_table.sql                            | Membuat tabel `mng_code`                                |
| 023  | 023_create_keywords_table.sql                            | Membuat tabel `keywords`                                |
| 024  | 024_create_movies_table.sql                              | Membuat tabel `movies`                                  |
| 025  | 025_create_poster_table.sql                              | Membuat tabel `poster`                                  |
| 026  | 026_create_streams_table.sql                             | Membuat tabel `streams`                                 |
| 027  | 027_create_article_table.sql                             | Membuat tabel `article`                                 |
| 028  | 028_create_podcast_table.sql                             | Membuat tabel `podcast`                                 |
| 029  | 029_create_podcast_data_table.sql                        | Membuat tabel `podcast_data`                            |
| 030  | 030_create_podcast_episode_table.sql                     | Membuat tabel `podcast_episode`                         |
| 031  | 031_create_podcast_recommendation_table.sql              | Membuat tabel `podcast_recommendation`                  |

---

## 🛠️ Cara Menjalankan

Jalankan masing-masing file SQL menggunakan:

```bash
mysql -u [username] -p [database_name] < path/to/sql/file.sql
