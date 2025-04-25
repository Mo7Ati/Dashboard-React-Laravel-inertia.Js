import { router, useForm } from "@inertiajs/react";
import React, { useEffect, useState } from 'react';
import { UploadOutlined } from '@ant-design/icons';
import {
    Input,
    Button,
    Form,
    TableProps,
    Table,
} from 'antd';
import { AbilityType, RoleType, } from "@/types/dashboard";

enum EForm {
    CREATE = 'create',
    EDIT = 'edit',
}

interface Iprops {
    role: RoleType;
    abilities: AbilityType[];
    errors: object;
    formType: string;
}

export default function RoleForm(props: Iprops) {

    const [abilities] = useState<AbilityType[]>(
        () => {
            return Object.entries(props.abilities).map(([ability, value]) => ({ ability, value }));
        });

    const {
        data,
        setData,
        errors,
        post,
    } = useForm<RoleType>(props.role);

    console.log(abilities)
    useEffect(() => {
        if (props.formType === EForm.EDIT) {
            setData('_method', 'PUT');
        } else {
            setData('_method', 'POST');
        }
    }, []);



    const handleSubmit = () => {
        if (props.formType === 'create') {
            post(route('dashboard.roles.store'));
        } else if (props.formType === 'edit') {
            post(route('dashboard.roles.update', props.role.id));
        }
    }
    const columns: TableProps<AbilityType>['columns'] = [
        {
            title: 'Ability',
            dataIndex: 'ability',
        },
        {
            title: 'Value',
            dataIndex: 'value',
        },
    ]

    return (
        <Form
            labelCol={{ span: 4 }}
            wrapperCol={{ span: 14 }}
            layout="horizontal"
            style={{ maxWidth: 800 }}
            onFinish={handleSubmit}
        >

            <Form.Item label="Role Name"
                help={
                    errors.name && (
                        <span className="ml-5  text-red-450 text-sm font-medium">
                            {errors.name}
                        </span>
                    )
                }
                validateStatus={errors.name && 'error'}
            >
                <Input
                    value={data.name}
                    onChange={(e) => {
                        errors.name = '';
                        setData('name', e.currentTarget.value)
                    }}
                />
            </Form.Item>


            <Form.Item label="Abilities"
                help={
                    errors.abilities && (
                        <span className="ml-5 text-red-450 text-sm font-medium">
                            {errors.abilities}
                        </span>
                    )
                }
                validateStatus={errors.abilities && 'error'}
            >

                <Table<AbilityType> columns={columns} dataSource={abilities} rowKey={'ability'} />

            </Form.Item>

            <Form.Item >
                <div className="flex gap-10 mt-1">
                    <Button color="primary" className="ml-20" htmlType="submit" variant="outlined">
                        {
                            (props.formType === EForm.CREATE) ? "Create" : "Edit"
                        }
                    </Button>
                    <Button color="danger" variant="outlined"
                        onClick={() => {
                            router.get(route('dashboard.roles.index'));
                        }}>
                        Cancel
                    </Button>
                </div>
            </Form.Item>
        </Form>
    );
}



