<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border-collapse: collapse;
            margin: 0 auto;
            width: 100%;
            text-align: center;
        }

        table, th, td {
            border: 1px solid black;
        }

    </style>
    <title>{{__('Invoice Information')}}</title>
</head>
<body>

{!!  sendDefferdMailContent($invoice_id) !!}

</body>
</html>