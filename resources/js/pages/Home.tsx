import axios from 'axios';
import { useEffect, useState } from 'react';

type Employee = {
    id: string;
    title: string;
    forename: string;
    surname: string;
};

type HomeProps = {
    employees: Employee[];
};

type Lesson = {
    id: string;
    start_at: string;
    end_at: string;
    class: LessonClass;
};

type Student = {
    id: string;
    forename: string;
    surname: string;
};

type LessonClass = {
    id: string;
    name: string;
    description: string;
    year_group: string;
    students: Student[];
};
export default function Home({ employees }: HomeProps) {
    const [employeeId, setEmployeeId] = useState<string>('');
    const [lessons, setLessons] = useState<Lesson[]>([]);
    const [startAfter, setStartAfter] = useState<string>('');
    const [loading, setLoading] = useState<boolean>(true);
    const [loadingClass, setLoadingClass] = useState<boolean>(false);
    const [lessonClass, setLessonClass] = useState<LessonClass | null>(null);
    const [classId, setClassId] = useState<string>('');

    useEffect(() => {
        // once the employee ID is populated, get the classes
        if (employeeId != '' && startAfter != '') {
            getLessonsForEmployee();
        }

        if (classId != '') {
            getClass();
        }
    }, [employeeId, startAfter, classId]);

    function getLessonsForEmployee() {
        setLoading(true);
        setLessons([]);
        axios
            .get(route('api.lessons.index', { employeeId: employeeId }), {
                params: { startAfter: startAfter },
            })
            .then((response) => {
                setLessons(response.data.data);
                setLoading(false);
            })
            .catch(() => {
                alert('there was an error retrieving lessons, please try again.');
            });
    }

    function getClass() {
        setLoadingClass(true);
        setLessonClass(null);
        axios
            .get(route('api.classes.show', { classId: classId }))
            .then((response) => {
                setLessonClass(response.data.data);
                setLoadingClass(false);
            })
            .catch(() => {
                alert('There was an error retrieving the students for this class, please try again.');
            });
    }

    const handleChange = (e: React.ChangeEvent<HTMLSelectElement>) => {
        setEmployeeId(e.target.value);
    };

    return (
        <>
            <div className="container mx-auto">
                <h1 className="mt-5 text-center text-2xl">View My Lessons</h1>
                <div className="mt-4 grid grid-cols-2 gap-2 border p-5">
                    <label htmlFor="employee-select">Please select your name</label>
                    <select id="employee-select" className={'border p-3'} onChange={handleChange} value={employeeId}>
                        <option value="">-- Select an employee --</option>
                        {employees.map((employee: Employee) => (
                            <option key={`employee-${employee.id}`} value={employee.id}>
                                {employee.title} {employee.forename} {employee.surname}
                            </option>
                        ))}
                    </select>
                </div>

                <div className="mt-4 grid grid-cols-2 gap-2 border p-5">
                    <label htmlFor="employee-select">Please select a date</label>
                    <div className={'border p-3'}>
                        <input type="date" onChange={(e) => setStartAfter(e.target.value)} />
                    </div>
                </div>

                <div className={'mt-3 grid gap-2 px-2 sm:grid-cols-2 sm:px-0'}>
                    <div>
                        {lessons.length > 0 && (
                            <table className={'w-full border'}>
                                <thead>
                                    <tr className={'border-b'}>
                                        <th className={'p-2 text-left'}>Lesson Date / Time</th>
                                        <th className={'p-2 text-left'}>Class Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {lessons.map((item: Lesson, index) => (
                                        <tr
                                            className={classId == item.class.id ? 'bg-blue-200' : '' + 'cursor-pointer border-b hover:bg-blue-100'}
                                            key={'class-' + item.id}
                                            onClick={() => setClassId(item.class.id)}
                                        >
                                            <td className={'p-2'}>{item.start_at}</td>
                                            <td className={'p-2'}>{item.class.name}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        )}

                        {lessons.length == 0 && !loading && (
                            <div className={'mt-1 text-center'}>There are no lessons for that day. Please choose another date.</div>
                        )}

                        {loading && employeeId != '' && startAfter != '' && <div className={'mt-1 text-center'}>Loading Lessons...</div>}
                    </div>

                    <div>
                        {employeeId && lessons.length > 0 && !loadingClass && !lessonClass && (
                            <div className={'border p-3'}>Select a lesson to display the students</div>
                        )}

                        {!loadingClass && lessonClass && (
                            <div className={'mb-3 font-bold'}>
                                <h2>Students in {lessonClass.name}</h2>
                            </div>
                        )}

                        {!loadingClass &&
                            lessonClass &&
                            lessonClass.students.data.map((student: Student, index) => (
                                <div key={'lesson-class-students-' + student.id}>
                                    {student.forename} {student.surname}
                                </div>
                            ))}

                        {loadingClass && <div>Loading Students...</div>}
                    </div>
                </div>
            </div>
        </>
    );
}
