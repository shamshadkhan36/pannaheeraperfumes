import os
from PIL import Image

SHEETS = [
    (
        r'C:\Users\Shamshad\.gemini\antigravity\brain\f5466b99-8d26-4ccc-b271-9cb35db310b2\perfumery_ingredients_grid_1794228385643.jpg',
        [
            ['oregano', 'basil', 'thyme'],
            ['green-notes', 'clary-sage', 'tea'],
            ['galbanum', 'rhubarb', 'juniper-berries']
        ]
    ),
    (
        r'C:\Users\Shamshad\.gemini\antigravity\brain\f5466b99-8d26-4ccc-b271-9cb35db310b2\spices_seeds_perfumery_grid_1794228385082.jpg',
        [
            ['pimento', 'black-pepper', 'coriander'],
            ['nutmeg', 'ginger', 'star-anise'],
            ['clove', 'caraway', 'cumin']
        ]
    ),
    (
        r'C:\Users\Shamshad\.gemini\antigravity\brain\f5466b99-8d26-4ccc-b271-9cb35db310b2\perfumery_base_notes_grid_1794228381339.jpg',
        [
            ['smoke', 'opoponax', 'labdanum'],
            ['benzoin', 'ambergris', 'ambroxan'],
            ['amberwood', 'elemi', 'styrax']
        ]
    ),
    (
        r'C:\Users\Shamshad\.gemini\antigravity\brain\f5466b99-8d26-4ccc-b271-9cb35db310b2\perfume_ingredients_3x3_grid_1794228387376.jpg',
        [
            ['coconut', 'almond', 'ylang-ylang'],
            ['pear', 'plum', 'litchi'],
            ['mango', 'honey', 'rum']
        ]
    ),
    (
        r'C:\Users\Shamshad\.gemini\antigravity\brain\f5466b99-8d26-4ccc-b271-9cb35db310b2\perfumery_notes_grid_3x3_1794228400447.jpg',
        [
            ['aldehydes', 'orange-blossom', 'tuberose'],
            ['lily-of-the-valley', 'geranium', 'magnolia'],
            ['freesia', 'caramel', 'pomegranate']
        ]
    )
]

out_dir = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), 'assets', 'images', 'notes')
os.makedirs(out_dir, exist_ok=True)

processed_count = 0
for sheet_path, grid in SHEETS:
    if not os.path.exists(sheet_path):
        print(f"ERROR: File not found: {sheet_path}")
        continue
    im = Image.open(sheet_path).convert('RGB')
    W, H = im.size
    cell_w = W // 3
    cell_h = H // 3
    
    for r in range(3):
        for c in range(3):
            name = grid[r][c]
            x1 = c * cell_w
            y1 = r * cell_h
            x2 = (c + 1) * cell_w if c < 2 else W
            y2 = (r + 1) * cell_h if r < 2 else H
            
            cell = im.crop((x1, y1, x2, y2))
            
            # Find bounding box of subject
            gray = cell.convert('L')
            bw = gray.point(lambda p: 255 if p < 246 else 0)
            bbox = bw.getbbox()
            
            if bbox:
                pad = 12
                bx1 = max(0, bbox[0] - pad)
                by1 = max(0, bbox[1] - pad)
                bx2 = min(cell.width, bbox[2] + pad)
                by2 = min(cell.height, bbox[3] + pad)
                subject = cell.crop((bx1, by1, bx2, by2))
            else:
                subject = cell
                
            # Make square canvas with white background
            sw, sh = subject.size
            max_side = max(sw, sh)
            square = Image.new('RGB', (max_side, max_side), (255, 255, 255))
            square.paste(subject, ((max_side - sw) // 2, (max_side - sh) // 2))
            
            # Convert near-white background to transparent RGBA
            square_rgba = square.convert('RGBA')
            datas = square_rgba.getdata()
            new_data = []
            for item in datas:
                if item[0] > 248 and item[1] > 248 and item[2] > 248:
                    new_data.append((255, 255, 255, 0))
                else:
                    new_data.append(item)
            square_rgba.putdata(new_data)
            
            final_note = square_rgba.resize((160, 160), Image.Resampling.LANCZOS)
            out_file = os.path.join(out_dir, f'{name}.png')
            final_note.save(out_file, 'PNG', optimize=True)
            processed_count += 1
            print(f'Processed & saved: {name}.png')

print(f'\nSUCCESS: Extracted and saved {processed_count} brand new note icons!')
