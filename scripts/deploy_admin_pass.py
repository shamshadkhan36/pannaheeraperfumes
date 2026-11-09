import paramiko

VPS_HOST = '148.113.17.68'
VPS_PORT = 20030
VPS_USER = 'root'
VPS_PASS = 'w62ldy79mTivFDUe'
REMOTE_BASE = '/var/www/html'

print(f"Connecting to VPS at {VPS_HOST}:{VPS_PORT}...")
ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect(VPS_HOST, port=VPS_PORT, username=VPS_USER, password=VPS_PASS, timeout=30)
print("Connected.")

sftp = ssh.open_sftp()
print("Uploading data/admin_user.json...")
sftp.put('data/admin_user.json', f'{REMOTE_BASE}/data/admin_user.json')

print("Uploading includes/storage.php...")
sftp.put('includes/storage.php', f'{REMOTE_BASE}/includes/storage.php')

sftp.close()

# Remove any /tmp/panna_admin_user.json if present
ssh.exec_command('rm -f /tmp/panna_admin_user.json')
ssh.exec_command(f'chown -R www-data:www-data {REMOTE_BASE}/data/admin_user.json {REMOTE_BASE}/includes/storage.php')
ssh.exec_command(f'chmod 644 {REMOTE_BASE}/data/admin_user.json {REMOTE_BASE}/includes/storage.php')
ssh.exec_command('systemctl reload php8.3-fpm nginx')

# Verify on VPS via php CLI
cmd = """php -r "require '/var/www/html/includes/storage.php'; echo 'New pass login: '; var_dump(loginAdmin('admin', 'pannaheera@#2026')); echo 'Old pass login: '; var_dump(loginAdmin('admin', 'admin123'));" """
stdin, stdout, stderr = ssh.exec_command(cmd)
print("\nVPS Verification Result:")
print(stdout.read().decode())
print(stderr.read().decode())

ssh.close()
print("Done!")
