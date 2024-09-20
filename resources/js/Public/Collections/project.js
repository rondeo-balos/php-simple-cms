export default {
    columns: [ 'image', 'project', 'link', 'status' ],
    icon: 'http://127.0.0.1:8000/storage/media/H6OyfuxHjnP4Ncsryl7eBm2V4YxIjOdCEfZhaEfF.svg',
    meta: {
        project: {
            control: 'text',
            default: 'Awesome Project'
        },
        general: {
            fields: {
                image: {
                    control: 'image'
                },
                description: {
                    control: 'textarea',
                },
            }
        },
        technical: {
            fields: {
                link: {
                    control: 'text',
                },
                framework: {
                    control: 'text',
                },
                status: {
                    control: 'select',
                    default: 'On-going',
                    values: {
                        'On-going': 'On-going',
                        'Done': 'Done'
                    }
                }
            }
        }
    }
};