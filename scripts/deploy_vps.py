import os
import paramiko

VPS_HOST = '148.113.17.68'
VPS_PORT = 20030
VPS_USER = 'root'
VPS_PASS = 'w62ldy79mTivFDUe'
REMOTE_BASE = '/var/www/html'

def ensure_remote_dir(sftp, remote_dir):
    dirs = []
    current = remote_dir
    while current and current != '/':
        dirs.append(current)
        current = os.path.dirname(current).replace('\\', '/')
    dirs.reverse()
    for d in dirs:
        try:
            sftp.stat(d)
        except IOError:
            try:
                sftp.mkdir(d)
                print(f"Created remote dir: {d}")
            except Exception as e:
                pass

def main():
    print(f"Connecting to VPS at {VPS_HOST}:{VPS_PORT}...")
    ssh = paramiko.SSHClient()
    ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    ssh.connect(VPS_HOST, port=VPS_PORT, username=VPS_USER, password=VPS_PASS, timeout=30)
    print("SSH connection established.")

    sftp = ssh.open_sftp()
    print("SFTP session opened.")

    files_to_upload = [
        ('config.php', f'{REMOTE_BASE}/config.php'),
        ('contact.php', f'{REMOTE_BASE}/contact.php'),
        ('index.php', f'{REMOTE_BASE}/index.php'),
        ('product-detail.php', f'{REMOTE_BASE}/product-detail.php'),
        ('fragrances.php', f'{REMOTE_BASE}/fragrances.php'),
        ('products.php', f'{REMOTE_BASE}/products.php'),
        ('includes/data.php', f'{REMOTE_BASE}/includes/data.php'),
        ('includes/header.php', f'{REMOTE_BASE}/includes/header.php'),
        ('includes/footer.php', f'{REMOTE_BASE}/includes/footer.php'),
        ('includes/modals.php', f'{REMOTE_BASE}/includes/modals.php'),
        ('includes/storage.php', f'{REMOTE_BASE}/includes/storage.php'),
        ('data/site_data.json', f'{REMOTE_BASE}/data/site_data.json'),
        ('data/notes_library.json', f'{REMOTE_BASE}/data/notes_library.json'),
        ('assets/js/products-data.js', f'{REMOTE_BASE}/assets/js/products-data.js'),
        ('assets/js/main.js', f'{REMOTE_BASE}/assets/js/main.js'),
        ('assets/images/whatsapp-icon.svg', f'{REMOTE_BASE}/assets/images/whatsapp-icon.svg'),
        ('assets/images/whatsapp-color.svg', f'{REMOTE_BASE}/assets/images/whatsapp-color.svg'),
        ('assets/images/categories/fragrance-oils.jpg', f'{REMOTE_BASE}/assets/images/categories/fragrance-oils.jpg'),
    ]

    # Add all 40 note images
    notes_dir = 'assets/images/notes'
    if os.path.exists(notes_dir):
        for img in os.listdir(notes_dir):
            if img.lower().endswith(('.png', '.jpg', '.webp')):
                local_path = os.path.join(notes_dir, img)
                remote_path = f'{REMOTE_BASE}/assets/images/notes/{img}'
                files_to_upload.append((local_path, remote_path))

    total = len(files_to_upload)
    for i, (local_p, remote_p) in enumerate(files_to_upload, 1):
        rem_dir = os.path.dirname(remote_p).replace('\\', '/')
        ensure_remote_dir(sftp, rem_dir)
        print(f"[{i}/{total}] Uploading {local_p} -> {remote_p}...")
        sftp.put(local_p, remote_p)

    sftp.close()
    print("\nAll files uploaded via SFTP.")

    # Fix permissions and reload services
    commands = [
        f"chown -R www-data:www-data {REMOTE_BASE}/",
        "chmod -R 755 /var/www/html/assets /var/www/html/data",
        "systemctl reload php8.3-fpm nginx || systemctl restart php8.3-fpm nginx"
    ]
    for cmd in commands:
        print(f"Executing remote: {cmd}")
        stdin, stdout, stderr = ssh.exec_command(cmd)
        out = stdout.read().decode('utf-8')
        err = stderr.read().decode('utf-8')
        if out.strip():
            print(f"  stdout: {out.strip()}")
        if err.strip():
            print(f"  stderr: {err.strip()}")

    ssh.close()
    print("\nVPS deployment complete and services reloaded successfully!")

if __name__ == '__main__':
    main()
