import subprocess
import json

# Generate bcrypt hash using php CLI
php_code = 'echo password_hash(\'pannaheera@#2026\', PASSWORD_DEFAULT);'
result = subprocess.run(['php', '-r', php_code], capture_output=True, text=True, check=True)
hashed = result.stdout.strip()
print('Generated hash:', hashed)

# Verify with php using single quotes to avoid PHP variable interpolation
verify_code = "var_dump(password_verify('pannaheera@#2026', '" + hashed + "'));"
ver_result = subprocess.run(['php', '-r', verify_code], capture_output=True, text=True, check=True)
print('Verification result:', ver_result.stdout.strip())

# Write to data/admin_user.json
data = {
    "username": "admin",
    "password": hashed
}
with open('data/admin_user.json', 'w', encoding='utf-8') as f:
    json.dump(data, f, indent=4)

print('Updated data/admin_user.json successfully!')
