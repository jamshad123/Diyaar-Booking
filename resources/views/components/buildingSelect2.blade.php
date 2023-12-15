<script type="text/javascript">
$(".select2-building_id").select2({
    placeholder: "Select Building",
    width: '100%',
    ajax: {
        url: '{{ route("Building::GetList") }}',
        dataType: 'json',
        method: 'post',
        delay: 250,
        data: function(data) {
            return {
                _token     : "{{ csrf_token() }}",
                search_tag : data.term,
            };
        },
        processResults: function(data, params) {
            params.page = params.page || 1;
            return {
                results: $.map(data.items, function(obj) { return { id: obj.id, text: obj.name }; }),
                pagination: { more: (params.page * 30) < data.total_count }
            };
        },
        cache: true
    },
});
$(".select2-building_id-list").select2({
    placeholder: "Select Building",
    width: '100%',
    ajax: {
        url: '{{ route("Building::GetList") }}',
        dataType: 'json',
        method: 'post',
        delay: 250,
        data: function(data) {
            return {
                _token     : "{{ csrf_token() }}",
                search_tag : data.term,
                list       : 0,
            };
        },
        processResults: function(data, params) {
            params.page = params.page || 1;
            return {
                results: $.map(data.items, function(obj) { return { id: obj.id, text: obj.name }; }),
                pagination: { more: (params.page * 30) < data.total_count }
            };
        },
        cache: true
    },
});
</script>
