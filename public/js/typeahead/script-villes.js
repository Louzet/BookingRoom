$(document).ready(function ()
{
    var url = Routing.generate('villes-json');
    var states = new Bloodhound(
        {
            datumTokenizer: Bloodhound.tokenizers.whitespace('name'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,


            remote: {
                url: url+"/%QUERY%",
                wildcard: '%QUERY%',
                transform: function (data) {          // we modify the prefetch response
                    var newData = [];                 // here to match the response format
                    data.forEach(function (item) {    // of the remote endpoint
                        newData.push({'name': item});
                    });
                    return newData;
                },
                filter: function (states)
                {
                    return $.map(states, function (state)
                    {
                        return {
                            state_name: state.ville_nom_reel,
                        }
                    })
                }
            }
        });

    states.initialize();

    $('.typeahead').typeahead(
{
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: 'states',
            source: states,
            display: 'state_name',
            templates: {
                suggestion: function (state)
                {
                    return  '<div>'+
                                '<span>' + state.state_name + '</span>'+
                            '</div>'
                },
                footer: function (query)
                {
                    return '<div class="text-center">More results about: '+ query.query +'</div>'
                }
            }
        })
});
