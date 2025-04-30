import { usePermissions } from "@/hooks/use-permissions";
import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { AdminType, CategoryType } from "@/types/dashboard";
import { Head, Link, router, usePage } from "@inertiajs/react";
import { Button, Flex, Space, Table, Image, message } from 'antd';
import axios from "axios";
import { useEffect, useState } from "react";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: route('dashboard.categories.index'),
    },
];

interface Iprops {
    categories: CategoryType[],
    auth: {
        user: AdminType;
        permissions: string[];
    },
    flash: { message: string },
}
export default function CategoriesIndex(props: Iprops) {

    const { Column } = Table;
    const [categories, setCategories] = useState<CategoryType[]>(props.categories as CategoryType[]);
    const [flashMessage, setFlashMessage] = useState<string>(props.flash.message);
    const [messageApi, contextHolder] = message.useMessage();
    const can = usePermissions();

    useEffect(() => {
        if (flashMessage) {
            messageApi.open({
                type: 'success',
                content: flashMessage,
            });
            setFlashMessage('');
        }
    }, [flashMessage, messageApi]);
    console.log(props);
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Categories" />
            {contextHolder}
            <div className="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
                {
                    can('create categories') && (
                        <div>
                            <Button
                                color="primary"
                                variant="outlined"
                                onClick={e => router.get(route('dashboard.categories.create'))}>
                                Add Category
                            </Button>
                        </div>)
                }
                <Table<CategoryType> dataSource={categories} pagination={false} rowKey="id" >
                    <Column title="Image" render={(_: any, record: CategoryType) => (
                        <>
                            <Image
                                height={80}
                                width={100}
                                src={record.image_url}
                            />
                        </>
                    )} />

                    <Column title="Name"
                        render={(_: any, record: CategoryType) => (
                            < Link href={`categories/${record.id}`}>{record.name}</Link>
                        )} />

                    <Column
                        title="Parent"
                        render={(_: any, record: CategoryType) => (
                            <>
                                {
                                    record.parent ? record.parent.name : ''
                                }
                            </>
                        )} />
                    <Column title="Status" dataIndex="status" />
                    <Column title="Description" dataIndex="description" width={'500px'} />

                    {
                        (can('delete categories') || can('update categories'))
                        &&
                        (
                            <Column
                                title="Action"
                                render={(_: any, record: CategoryType) => (
                                    <Space size="middle">
                                        <Flex gap="small">
                                            {
                                                can('update categories') && (
                                                    <Button
                                                        color="primary"
                                                        variant="outlined"
                                                        onClick={
                                                            e =>
                                                                router.visit(route('dashboard.categories.edit', record.id))
                                                        }>
                                                        Edit
                                                    </Button>
                                                )
                                            }

                                            {
                                                can('delete categories') && (
                                                    <Button color="danger" variant="outlined" onClick={e => {
                                                        axios.delete(`categories/${record.id}`)
                                                            .then(_ => {
                                                                setCategories(prev => prev.filter(category => category.id !== record.id));
                                                                setFlashMessage("Category Deleted Successfully");
                                                            });
                                                    }}>
                                                        Delete
                                                    </Button>
                                                )
                                            }
                                        </Flex>
                                    </Space>
                                )}
                            />
                        )
                    }
                </Table>
            </div>
        </AppLayout >
    );
}

