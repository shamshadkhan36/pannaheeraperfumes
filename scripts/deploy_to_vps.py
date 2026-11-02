import os
import sys
import paramiko
import time

VPS_HOST = '148.113.17.68'
VPS_PORT = 20030
VPS_USER = 'root'
VPS_PASS = 'w62ldy79mTivFDUe'
REMOTE_WEBROOT = '/var/www/html'

BASE_DIR = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

def deploy():
    print(f"Connecting to VPS {VPS_HOST}:{VPS_PORT} as {VPS_USER}...")
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(VPS_HOST, port=VPS_PORT, username=VPS_USER, password=VPS_PASS, timeout=30)
    print("SSH connection established.")

    sftp = ssh.open_sftp()
    print("SFTP channel opened.")

    # 1. Upload files
    files_to_upload = [
        ('scratch_products.zip', '/tmp/scratch_products.zip'),
        ('scratch_notes.zip', '/tmp/scratch_notes.zip'),
        ('data/site_data.json', f'{REMOTE_WEBROOT}/data/site_data.json'),
        ('data/notes_library.json', f'{REMOTE_WEBROOT}/data/notes_library.json'),
        ('assets/js/fragrance-data.js', f'{REMOTE_WEBROOT}/assets/js/fragrance-data.js'),
        ('fragrances.php', f'{REMOTE_WEBROOT}/fragrances.php'),
        ('products.php', f'{REMOTE_WEBROOT}/products.php'),
        ('product-detail.php', f'{REMOTE_WEBROOT}/product-detail.php'),
    ]

    for local_rel, remote_path in files_to_upload:
        local_full = os.path.join(BASE_DIR, local_rel.replace('/', os.sep))
        size_mb = os.path.getsize(local_full) / (1024 * 1024)
        print(f"Uploading {local_rel} ({size_mb:.2f} MB) -> {remote_path}...")
        t0 = time.time()
        sftp.put(local_full, remote_path)
        print(f"  Done in {time.time()-t0:.1f}s")

    sftp.close()

    # 2. Execute extraction & commands on VPS
    commands = [
        "mkdir -p /var/www/html/assets/images/products /var/www/html/assets/images/notes /var/www/html/data",
        "unzip -o -q /tmp/scratch_products.zip -d /var/www/html/assets/images/products/",
        "unzip -o -q /tmp/scratch_notes.zip -d /var/www/html/assets/images/notes/",
        "rm -f /tmp/scratch_products.zip /tmp/scratch_notes.zip",
        "chown -R www-data:www-data /var/www/html",
        "chmod -R 755 /var/www/html/assets/images /var/www/html/data",
        "systemctl reload php8.3-fpm 2>/dev/null || systemctl reload php-fpm 2>/dev/null || true",
        "systemctl reload nginx",
        "echo 'Product images count:' $(ls -1 /var/www/html/assets/images/products/*.webp | wc -l)",
        "echo 'Note icons count:' $(ls -1 /var/www/html/assets/images/notes/*.png | wc -l)"
    ]

    for cmd in commands:
        print(f"Executing: {cmd}")
        stdin, stdout, stderr = ssh.exec_command(cmd)
        out = stdout.read().decode('utf-8').strip()
        err = stderr.read().decode('utf-8').strip()
        if out:
            print(f"  [OUT] {out}")
        if err:
            print(f"  [ERR] {err}")

    ssh.close()
    print("\nDEPLOYMENT COMPLETED SUCCESSFULLY!")

if __name__ == '__main__':
    deploy()
