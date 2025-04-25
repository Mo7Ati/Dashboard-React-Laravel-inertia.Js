import AppLayout from "@/layouts/app-layout";
import { BreadcrumbItem } from "@/types";
import { ProductType } from "@/types/dashboard";
import { Head, Link, router, usePage } from "@inertiajs/react";
import { Button, Flex, Space, Table, Image, Pagination, message } from 'antd';
import axios from "axios";
import { useEffect, useState } from "react";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Products',
        href: route('dashboard.products.index'),
    },
];

interface Iprops {
    products: {
        data: ProductType[],
        per_page: number,
        current_page: number,
    },
    total_products: number,
    flash: { message: string },
}
export default function ProductsIndex(props: Iprops) {

    const { Column } = Table;
    const [products, setProducts] = useState<ProductType[]>(props.products.data);
    const [flashMessage, setFlashMessage] = useState<string>(props.flash.message);
    const [messageApi, contextHolder] = message.useMessage();


    useEffect(() => {
        if (flashMessage) {
            messageApi.open({
                type: 'success',
                content: flashMessage,
            });
            setFlashMessage('');
        }
    }, [flashMessage, messageApi]);


    const onPageChange = (page: number, pageSize: number) => {
        router.get(route('dashboard.products.index'), { page });
    }

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Products" />
            {contextHolder}
            <div className="rounded-xl p-4">
                <Button
                    color="primary"
                    variant="outlined"
                    className="mb-2"
                    onClick={() => router.get(route('dashboard.products.create'))}
                >
                    Add Product
                </Button>
                <Table<ProductType> dataSource={products} rowKey="id" pagination={false} >
                    <Column title="Image" render={(_: any, record: ProductType) => (
                        <>
                            <Image
                                height={63}
                                width={100}
                                src={record.image_url}
                            />
                        </>
                    )} />

                    <Column title="Name" dataIndex={'name'} />

                    <Column
                        title="Category"
                        render={(_: any, record: ProductType) => (
                            <>
                                {
                                    record.category.name
                                }
                            </>
                        )} />
                    <Column
                        title="Store"
                        render={(_: any, record: ProductType) => (
                            <>
                                {
                                    record.store.name
                                }
                            </>
                        )} />
                    <Column title="Status" dataIndex="status" />
                    <Column title="Price" dataIndex="price" />
                    <Column title="Compare Price" dataIndex="compare_price" />
                    <Column title="Description" dataIndex="description" />
                    <Column title="Quantity" dataIndex="quantity" />

                    <Column
                        title="Action"
                        render={(_: any, record: ProductType) => (
                            <Space size="middle">
                                <Flex gap="small">

                                    <Button
                                        color="primary"
                                        variant="outlined"
                                        onClick={e => {
                                            router.get(route('dashboard.products.edit', record))
                                        }}
                                    >
                                        Edit
                                    </Button>

                                    <Button color="danger" variant="outlined" onClick={e => {
                                        axios.delete(route('dashboard.products.destroy', record))
                                            .then(_ => {
                                                setProducts(prev => prev.filter(product => product.id !== record.id));
                                                setFlashMessage("Product Deleted Successfully");
                                            });
                                    }}>
                                        Delete
                                    </Button>
                                </Flex>
                            </Space>
                        )}
                    />
                </Table>
                <div className="mt-5">
                    <Pagination
                        align="start"
                        current={props.products.current_page}
                        defaultCurrent={1}
                        total={props.total_products}
                        pageSize={props.products.per_page}
                        onChange={onPageChange}
                    />
                </div>
            </div>
        </AppLayout >
    );
}

