import paramiko

ssh = paramiko.SSHClient()
ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
ssh.connect('148.113.17.68', port=20030, username='root', password='w62ldy79mTivFDUe', timeout=15)

cmd = """php -r '$d = json_decode(file_get_contents("/var/www/html/data/site_data.json"), true); foreach($d["products"] as $p){ if(in_array($p["sno"], [3, 6, 9, 10, 20, 163, 167])) { echo "#".$p["sno"]." | ".$p["title"]." | Ref: ".$p["fragrantica_reference"].PHP_EOL."   Top: ".implode(", ", array_column($p["notes"]["top"], "name")).PHP_EOL."   Mid: ".implode(", ", array_column($p["notes"]["middle"], "name")).PHP_EOL."   Base: ".implode(", ", array_column($p["notes"]["base"], "name")).PHP_EOL.PHP_EOL; } }'"""

stdin, stdout, stderr = ssh.exec_command(cmd)
print(stdout.read().decode())
ssh.close()
