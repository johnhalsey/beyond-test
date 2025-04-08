
export default function Error() {

    return (
        <>
            <div className="container mx-auto ">
                <h1 className="text-2xl text-center mt-5 text-red-500">Sorry there was an error!</h1>
                <div className="text-center">
                    <p><a href='/' className={'text-blue-400 hover:text-blue-600 cursor-pointer'}>Please try again here</a></p>
                </div>
            </div>
        </>
    );
}
