<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Print Shopping List</title>
    <style>
        @page { margin: 0; }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 58mm; 
            padding: 10px;
            font-size: 11px; /* Slightly smaller for more details */
            color: black;
            line-height: 1.2;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .border-dashed { border-bottom: 1px dashed black; margin: 8px 0; }
        
        .category-header { 
            text-transform: uppercase; 
            font-weight: black; 
            border-bottom: 1px solid black;
            margin-top: 10px;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        .item-row { margin-bottom: 6px; }
        .item-main { display: flex; justify-content: space-between; font-weight: bold; }
        .item-sub { font-size: 9px; color: #333; }

        .no-print { 
            background: #000; color: #fff; padding: 12px; 
            text-align: center; text-decoration: none; 
            display: block; margin-bottom: 20px;
            font-family: sans-serif; font-weight: bold; border-radius: 8px;
        }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">

    <a href="javascript:history.back()" class="no-print">⬅️ BUMALIK SA LISTAHAN</a>

    <div class="text-center">
        <h2 style="margin:0; text-transform:uppercase; font-size: 16px;">Cup of Arc</h2>
        <p style="margin:2px 0; letter-spacing: 2px;">SHOPPING LIST</p>
        <p style="margin:0; font-size:9px;">{{ date('M d, Y | h:i A') }}</p>
    </div>

    <div class="border-dashed"></div>

    {{-- I-group natin ang items by Category --}}
    @php
        $groupedItems = $items->groupBy(function($item) {
            return $item->inventory->category;
        });
    @endphp

    @forelse($groupedItems as $category => $categoryItems)
        <div class="category-header">{{ $category }}</div>
        
        @foreach($categoryItems as $item)
            <div class="item-row">
                <div class="item-main">
                    <span>[ ] {{ $item->inventory->item_name }}</span>
                </div>
                <div class="item-sub">
                    REM: {{ $item->inventory->quantity }} {{ $item->inventory->unit ?? 'pcs' }}
                </div>
            </div>
        @endforeach
    @empty
        <p class="text-center text-xs">No pending items to buy.</p>
    @endforelse

    <div class="border-dashed"></div>

    <div class="text-center" style="font-size: 9px; margin-top: 15px;">
        *** Management v2 ***<br>
        Check items as you shop.
    </div>

</body>
</html>