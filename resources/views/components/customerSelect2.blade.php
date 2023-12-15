<script type="text/javascript">
$(".select2-customer_id").select2({
    placeholder: "Select Customer",
    width: '100%',
    ajax: {
        url: '{{ route("Customer::GetList") }}',
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
</script>
